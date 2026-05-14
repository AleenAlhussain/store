import 'dart:math' as math;

import 'package:get/get.dart';

import '../../../app/theme/app_colors.dart';
import '../../../core/controllers/theme_controller.dart';

class CompanionMessage {
  final String text;
  final bool isUser;
  final DateTime time;

  CompanionMessage({required this.text, required this.isUser})
      : time = DateTime.now();
}

class CompanionController extends GetxController {
  final messages  = <CompanionMessage>[].obs;
  final isTyping  = false.obs;

  ThemeController get _theme => Get.find<ThemeController>();

  AppThemeVariant get _variant => _theme.variant.value;

  String get characterName => switch (_variant) {
        AppThemeVariant.quantum => 'Tutor',
        AppThemeVariant.luna    => 'Luna',
        AppThemeVariant.milo    => 'Milo',
        AppThemeVariant.sunny   => 'Sunny',
      };

  String get characterMood => switch (_variant) {
        AppThemeVariant.quantum => 'Ready to explore chemistry with you',
        AppThemeVariant.luna    => 'Here to make learning magical ✨',
        AppThemeVariant.milo    => "Let's crush today's challenges! 💪",
        AppThemeVariant.sunny   => 'Packed with fun facts just for you ☀️',
      };

  @override
  void onInit() {
    super.onInit();
    _sendWelcome();
  }

  // ---------- public API ----------

  void sendUserMessage(String text) {
    if (text.trim().isEmpty) return;
    messages.add(CompanionMessage(text: text.trim(), isUser: true));
    isTyping.value = true;
    Future.delayed(const Duration(milliseconds: 1100), () {
      isTyping.value = false;
      messages.add(CompanionMessage(
        text: _generateResponse(text.trim().toLowerCase()),
        isUser: false,
      ));
    });
  }

  void sendQuickReply(String type) {
    final label = switch (type) {
      'tip'       => 'Give me a chemistry tip! 🧪',
      'encourage' => 'I need some encouragement! 💪',
      'quiz'      => 'Quiz me on something! 🎯',
      'fact'      => 'Tell me a fun fact! 🌟',
      _           => type,
    };
    sendUserMessage(label);
  }

  // ---------- welcome ----------

  void _sendWelcome() {
    final hour = DateTime.now().hour;
    final timeGreet =
        hour < 12 ? 'Good morning' : hour < 17 ? 'Good afternoon' : 'Good evening';

    final options = switch (_variant) {
      AppThemeVariant.quantum => [
        "$timeGreet, scholar! The lab is open and the cosmos is waiting. Every molecule has a story — let's read one together. 🔬",
        "$timeGreet! Did you know every atom in your body was forged inside a dying star? Chemistry connects you to the universe itself. ✨",
      ],
      AppThemeVariant.luna => [
        "$timeGreet, bestie! 🌸 I missed you SO much! Ready to make chemistry feel like magic today? I promise it'll be super fun!",
        "$timeGreet! 💕 I've been thinking of the cutest way to explain electrons to you. Spoiler: they're basically tiny party guests who can't stop moving! 🎉",
      ],
      AppThemeVariant.milo => [
        "$timeGreet! Ready to level up? 🎮 Chemistry is basically the ultimate cheat code for understanding how everything works. Let's go!",
        "$timeGreet, warrior! 💪 Every hard concept you master today is XP in the bank. I've got drills ready — are you?",
      ],
      AppThemeVariant.sunny => [
        "$timeGreet! ☀️ I am SO excited to explore chemistry with you! Every question you ask makes me happy because I just love sharing what I know!",
        "$timeGreet! Did you know chemistry is literally everywhere? Your breakfast, your clothes, the air you breathe — all chemistry! Let me tell you more! 🌟",
      ],
    };

    messages.add(CompanionMessage(
      text: options[math.Random().nextInt(options.length)],
      isUser: false,
    ));
  }

  // ---------- response router ----------

  String _generateResponse(String input) {
    if (_matches(input, ['tip', 'chemistry tip', 'lesson', 'learn', 'teach'])) {
      return _tip();
    }
    if (_matches(input, ['encourage', 'motivation', 'motivat', 'help me', "can't do", 'hard', 'difficult', 'struggling'])) {
      return _encourage();
    }
    if (_matches(input, ['quiz', 'test me', 'question', 'challenge', 'ask me'])) {
      return _quiz();
    }
    if (_matches(input, ['fact', 'fun fact', 'cool', 'interesting', 'did you know'])) {
      return _fact();
    }
    if (_matches(input, ['hello', 'hi', 'hey', 'hiya', 'sup'])) {
      return _greeting();
    }
    if (_matches(input, ['thank', 'thanks', 'thx'])) {
      return _thankYou();
    }
    return _fallback();
  }

  bool _matches(String input, List<String> keywords) =>
      keywords.any((k) => input.contains(k));

  // ---------- response banks ----------

  String _tip() {
    final tips = switch (_variant) {
      AppThemeVariant.quantum => [
        '💡 Tip: When balancing equations, count atoms on BOTH sides. The law of conservation of mass means matter cannot be created or destroyed.\n\nExample: 2H₂ + O₂ → 2H₂O ✓',
        '💡 Tip: The periodic table is sorted by atomic number — the number of protons. Elements in the same column share similar chemical properties.\n\nGroup 1 (alkali metals) all react vigorously with water!',
        '💡 Tip: Electronegativity increases across a period (left→right) and decreases down a group. Fluorine (F) is the most electronegative element of all.',
        '💡 Tip: Covalent bonds form between non-metals SHARING electrons. Ionic bonds form when a metal TRANSFERS electrons to a non-metal.\n\nNaCl = ionic. H₂O = covalent.',
        '💡 Tip: pH scale runs 0–14. Pure water is 7 (neutral). Below 7 = acidic (more H⁺ ions). Above 7 = basic (more OH⁻ ions).',
      ],
      AppThemeVariant.luna => [
        '✨ Tip: Think of the periodic table like a fashion collection — elements in the same group have matching "personalities" and similar properties! Group 1 girls are ALL bold and reactive! 💅',
        '🌸 Tip: Balancing equations is like balancing your outfit — equal atoms on both sides means perfect harmony! Try: H₂ + O₂ → H₂O (needs balancing — can you spot why?) 💕',
        '💕 Tip: Covalent bonds are like besties sharing earrings (electrons). Ionic bonds are like giving your necklace to someone who needs it more than you! 🎀',
        '🌟 Tip: pH is a beauty scale for chemistry! 0–6 is acidic (like lemon juice), 8–14 is basic (like shampoo), 7 is perfectly balanced like your skincare routine!',
        '🎀 Tip: Valence electrons are the social butterflies of chemistry — they live in the outermost shell and are ALWAYS looking to bond with others! The more the merrier! ✨',
      ],
      AppThemeVariant.milo => [
        '⚡ Tip: Balancing equations = making sure both teams have equal players. H₂ + O₂ → H₂O needs balancing! Correct: 2H₂ + O₂ → 2H₂O. GG! 🎮',
        '🎮 Tip: The periodic table is your map. Same column = same "class" with similar abilities. Use it to PREDICT how elements behave before you even test them!',
        '💪 Tip: OIL RIG — remember this: Oxidation Is Loss (of electrons), Reduction Is Gain. In every redox reaction, one element levels up while another loses stats!',
        '🔥 Tip: Exothermic = releases heat (hand warmers, fire). Endothermic = absorbs heat (ice packs). Know which reaction you\'re dealing with before you experiment!',
        '⚔️ Tip: Acids have pH < 7 and release H⁺ ions. Bases have pH > 7 and release OH⁻ ions. When they fight, they neutralize each other — producing salt and water!',
      ],
      AppThemeVariant.sunny => [
        '☀️ Tip: The periodic table has a beautiful pattern! As you go right, atoms gain protons. As you go down, atoms get bigger electron shells. It\'s like a map of all matter! 🗺️',
        '🌻 Tip: Chemical reactions are just atoms rearranging — like shuffling puzzle pieces into a new picture. No atoms appear or disappear, they just move around! 🧩',
        '✨ Tip: Water is called the "universal solvent" because SO many things dissolve in it! That\'s why water is essential for all life on Earth! 💧',
        '🌈 Tip: When you see a color change in a reaction, new substances are being formed! Color is chemistry\'s way of saying something amazing just happened! 🎨',
        '🎉 Tip: Acids + Bases = Neutralization! They cancel each other out, often making water and a salt. It\'s like chemistry\'s version of a happy ending! 💫',
      ],
    };
    return tips[math.Random().nextInt(tips.length)];
  }

  String _encourage() {
    final msgs = switch (_variant) {
      AppThemeVariant.quantum => [
        'Remember: Marie Curie worked in a leaky shed with no proper equipment. Einstein failed his university entrance exam. Every great scientist started exactly where you are now.\n\nYour curiosity is your greatest instrument. 🔬',
        'Chemistry feels complex because it describes reality at its deepest level. When you feel confused, that\'s not failure — it\'s your brain building new neural connections.\n\nKeep going. The breakthrough is always closer than it feels.',
        'Progress in science is not linear. Every Nobel Prize winner had days when nothing made sense.\n\nWhat matters is that you showed up today. That\'s what separates those who succeed from those who don\'t. ⭐',
      ],
      AppThemeVariant.luna => [
        'Hey, YOU. You are SO much smarter than you give yourself credit for! 💕 Every single time you study, your brain literally gets stronger. You\'re building the most beautiful mind!\n\nI believe in you with my whole heart! 🌸',
        'Some days chemistry is harder than others and that is COMPLETELY okay! 🤗 What matters is you showed up anyway. You know what that makes you? Incredible.\n\nYou\'ve got this, bestie! Always! 💕',
        'Can I tell you something? The fact that you\'re asking for encouragement shows how self-aware and mature you are! 🌟 That quality will take you so far in life.\n\nNow let\'s tackle this together — I\'m right here! 💕',
      ],
      AppThemeVariant.milo => [
        "Real talk: the students who succeed aren't the ones who find it easiest — they're the ones who refuse to quit. Right now, you choosing to keep going? That's the actual power move. 💪\n\nLet's get back in the game!",
        "Struggling with something? GOOD. That means you're pushing past your comfort zone — and that's EXACTLY where growth happens. Every warrior has their tough days.\n\nYou're not stuck. You're leveling up. ⚡",
        'Bro, you\'re literally in the middle of a boss battle right now. It\'s SUPPOSED to be hard. That\'s what makes the victory worth it.\n\nDon\'t quit before the win screen. I\'m right here with you. 🎮',
      ],
      AppThemeVariant.sunny => [
        'Oh I am SO glad you asked! ☀️ Here\'s what I know: showing up and asking for help is the single most important thing in learning. And you just did BOTH.\n\nEvery expert was once exactly where you are. Keep going — I truly believe in you! 🌟',
        'You want to know the secret about chemistry? It\'s not about being the smartest — it\'s about being the most curious. And curiosity? You have it in ABUNDANCE!\n\nThe concepts that feel impossible today will feel easy to explain to others someday soon! 🌈',
        'You know what I\'ve noticed about you? You keep coming back! ✨ That consistency — showing up even on hard days — is literally the ingredient that separates good students from great ones.\n\nYou\'re already doing it. I\'m so proud of you! ☀️',
      ],
    };
    return msgs[math.Random().nextInt(msgs.length)];
  }

  String _quiz() {
    final quizzes = switch (_variant) {
      AppThemeVariant.quantum => [
        '⚗️ Quiz: What is the atomic number of Carbon?\n\n🔍 Hint: It\'s in Period 2, Group 14. Carbon forms the backbone of all organic molecules.\n\nTake your time — think about where it sits on the periodic table!',
        '🔬 Challenge: How many electrons can the SECOND shell of an atom hold?\n\n🔍 Hint: Use the formula 2n² where n is the shell number.\n\nBonus: What element fills exactly two shells?',
        '⚗️ Question: What is the difference between an ATOM and a MOLECULE?\n\n🔍 Hint: One is a single unit. The other is a combination of bonded units.\n\nGive me an example of each when you answer!',
      ],
      AppThemeVariant.luna => [
        '💕 Quiz time bestie! What element makes up 78% of the air we breathe?\n\n🌸 Hint: It\'s NOT Oxygen — that one surprises everyone! Oxygen is only about 21%.\n\nThink about what\'s even more common... 🤔',
        '✨ Little quiz! What do you call it when a solid turns DIRECTLY into a gas without becoming liquid first?\n\n🎀 Hint: Think about dry ice or iodine crystals — have you ever seen them \'smoke\'?\n\nSo cool right?! 💕',
        '🌟 Quiz! What\'s the difference between an element and a compound?\n\n💕 Hint: One is a pure substance with ONE type of atom. The other has TWO or more types bonded together!\n\nYou totally know this one, I believe in you! 🌸',
      ],
      AppThemeVariant.milo => [
        '⚔️ BOSS BATTLE: What\'s the chemical symbol for Gold, and why isn\'t it just "Go"?\n\n💡 Hint: Look up where "Au" comes from — it\'s from an ancient language!\n\nHistory + chemistry combo! Can you figure it out? 🎮',
        '🎯 CHALLENGE: Name the three states of matter AND give one real-world example of each.\n\n💡 Hint: They involve particles moving at different speeds and distances apart.\n\nBonus points: What\'s the FOURTH state of matter? ⚡',
        '💪 HARD MODE: What is the difference between an exothermic and endothermic reaction?\n\n💡 Hint: Think HEAT — one releases it, one absorbs it. Hand warmers vs ice packs!\n\nBonus: Give one example of each you\'ve seen in real life! 🔥',
      ],
      AppThemeVariant.sunny => [
        '☀️ Fun quiz! How many elements are currently on the periodic table?\n\n🌻 Hint: It\'s more than 100! Scientists keep adding new ones they make in labs.\n\nI\'ll give you a clue — the number is between 115 and 120! 😊',
        '🌈 Question: What do you call atoms of the same element that have different numbers of NEUTRONS?\n\n✨ Hint: They\'re used in medicine for imaging and in nuclear energy!\n\nThey have the same chemical behavior but different masses — how interesting! 🌟',
        '🎉 Easy one! What is the chemical formula for table salt?\n\n☀️ Hint: It\'s made from one metal from Group 1 and one non-metal from Group 17!\n\nYou\'ve probably touched this one today already 😄',
      ],
    };
    return quizzes[math.Random().nextInt(quizzes.length)];
  }

  String _fact() {
    final facts = [
      '🌟 Fun fact: If you removed all the empty space from the atoms in every human on Earth — all 8 billion of us — we would fit inside a sugar cube. Most of an atom is just empty space!',
      '⚡ Fun fact: Diamond and graphite are BOTH made of pure carbon atoms. The only difference is how those atoms are arranged. Same ingredients, completely different properties!',
      '🔬 Fun fact: A teaspoon of a neutron star material would weigh about 10 million tonnes. That\'s how densely packed an atomic nucleus can become!',
      '✨ Fun fact: The human body is about 60% water — and 99% of all atoms in your body are hydrogen, oxygen, carbon, or nitrogen!',
      '🧪 Fun fact: Hot water can freeze faster than cold water under certain conditions. This is called the Mpemba Effect and scientists still debate exactly why it happens!',
      '🌈 Fun fact: Gold is so chemically unreactive that gold nuggets found today are just as pure as when they formed millions of years ago. Gold never rusts or corrodes!',
      '💫 Fun fact: Oxygen was discovered TWICE — by Carl Scheele in 1773 and Joseph Priestley in 1774. They didn\'t know about each other\'s work!',
      '🌊 Fun fact: The ocean contains about 20 million tonnes of GOLD dissolved in it — but at such low concentration (about 13 parts per trillion) it\'s impossible to extract economically.',
    ];

    final suffix = switch (_variant) {
      AppThemeVariant.quantum => '\n\nChemistry never stops being fascinating. 🔬',
      AppThemeVariant.luna    => '\n\nIsn\'t chemistry just the most magical thing? 🌸💕',
      AppThemeVariant.milo    => '\n\nMind = blown right?! Science is wild! 🤯⚡',
      AppThemeVariant.sunny   => '\n\nI could share facts like this ALL day! ☀️😊',
    };

    return facts[math.Random().nextInt(facts.length)] + suffix;
  }

  String _greeting() => switch (_variant) {
        AppThemeVariant.quantum => 'Hello! I\'m here and the lab is ready. What shall we explore together today? A concept, a quiz, a tip? 🔬',
        AppThemeVariant.luna    => 'Heyyyy! 🌸 It\'s so good to hear from you! I\'m fully charged and ready to make chemistry super fun. What do you need? 💕',
        AppThemeVariant.milo    => 'YO! What\'s up! Ready to conquer some chemistry today? I\'m warmed up — let\'s GO! ⚡🎮',
        AppThemeVariant.sunny   => 'Hello hello! ☀️ I\'m SO happy you said hi! You just made my day better. What should we explore together? 🌟',
      };

  String _thankYou() => switch (_variant) {
        AppThemeVariant.quantum => 'You\'re very welcome. Your intellectual curiosity is what makes science meaningful. Keep asking great questions — that\'s the scientific spirit. 🔬',
        AppThemeVariant.luna    => 'Awww you\'re SO welcome bestie! 💕 That\'s literally what I\'m here for! You make my whole day brighter every time you come to study! 🌸',
        AppThemeVariant.milo    => 'No problem! That\'s what teammates are for — we win together! Now let\'s keep grinding and leveling up! 💪🎮',
        AppThemeVariant.sunny   => 'Oh YOU\'RE so welcome! ☀️ Honestly, THANK YOU for letting me share all of this with you. I genuinely love it! Come back anytime! 🌟',
      };

  String _fallback() {
    final options = switch (_variant) {
      AppThemeVariant.quantum => [
        'An interesting message! Chemistry is vast. You can ask me for a tip, a quiz challenge, an encouraging word, or a fascinating fact — I\'m here for all of it. 🔬',
        'I\'m your dedicated chemistry companion. Try asking for a tip, a quiz, or encouragement — let\'s make the most of our session! ⚗️',
      ],
      AppThemeVariant.luna => [
        'Oooh! 🌸 I\'m here to help with ANYTHING chemistry-related! Ask me for a tip, quiz, encouragement, or a fun fact — I\'ve got you covered, bestie! 💕',
        'You\'re so cute for messaging me! 🌟 Try asking for a chemistry tip, a fun quiz, or just tell me you need encouragement — I\'m ALL yours! ✨',
      ],
      AppThemeVariant.milo => [
        'Nice! Keep that energy! Ask me for a chemistry tip, a quiz challenge, a fun fact, or some motivation and we\'ll level up together! ⚡🎮',
        'I hear you! Chemistry is a big battlefield. Ask for tips, quizzes, facts, or encouragement — let\'s strategize and dominate! 💪',
      ],
      AppThemeVariant.sunny => [
        'Oh I love getting messages! ☀️ Ask me for chemistry tips, fun facts, quizzes, or encouragement — I genuinely love sharing everything I know with you! 🌟',
        'Great to hear from you! Chemistry connects to SO much in life. Try asking for a tip, a fun fact, or a quiz — let\'s explore together! 🌈',
      ],
    };
    return options[math.Random().nextInt(options.length)];
  }
}
