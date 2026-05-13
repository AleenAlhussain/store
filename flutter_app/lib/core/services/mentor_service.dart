import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../../data/models/mentor_model.dart';

class MentorService extends GetxService {
  final current = Rxn<MentorModel>();

  @override
  Future<void> onInit() async {
    super.onInit();
    await _load();
  }

  Future<void> _load() async {
    final prefs = await SharedPreferences.getInstance();
    final id = prefs.getString('mentor_id');
    if (id != null) {
      current.value = MentorModel.defaults.firstWhereOrNull((m) => m.id == id);
    }
  }

  Future<void> setMentor(String id) async {
    current.value = MentorModel.defaults.firstWhereOrNull((m) => m.id == id);
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('mentor_id', id);
  }

  String get greeting => switch (current.value?.id) {
        'professor'   => 'Welcome back, scholar.',
        'gamer'       => 'Ready to level up?',
        'visionary'   => 'The future awaits, explorer.',
        'minimalist'  => "Let's get to it.",
        'storyteller' => 'A new chapter begins.',
        'lab_partner' => 'Hey! Ready to experiment?',
        _             => 'Systems Active,',
      };

  String get chatOpener => switch (current.value?.id) {
        'professor'   => 'Good day. Today we rigorously examine a fundamental reaction.\n\n2H₂ + O₂ → 2H₂O',
        'gamer'       => '⚔️ New quest unlocked! Defeat the Hydrogen-Oxygen boss.\n\n2H₂ + O₂ → 2H₂O',
        'visionary'   => 'Imagine: two H₂ molecules fuse with O₂, birthing water itself.\n\n2H₂ + O₂ → 2H₂O',
        'minimalist'  => '2H₂ + O₂ → 2H₂O',
        'storyteller' => 'Long ago, in the quantum realm, Hydrogen met Oxygen...\n\n2H₂ + O₂ → 2H₂O',
        'lab_partner' => 'Hey! Check this out — look what happens when hydrogen meets oxygen! 🧪\n\n2H₂ + O₂ → 2H₂O',
        _             => 'Let\'s look at the reaction between Hydrogen and Oxygen.\n\n2H₂ + O₂ → 2H₂O',
      };

  String responseFor(String userMessage) => switch (current.value?.id) {
        'professor'   => 'Excellent question. In this context we observe a covalent bond — shared electron pairs between non-metal atoms. The electronegativity difference of 1.4 confirms polarity.',
        'gamer'       => '🎯 Critical hit! That\'s a covalent bond — atoms sharing electrons like teammates sharing resources. +50 XP unlocked! 🔥',
        'visionary'   => 'Fascinating! What you\'re observing is quantum entanglement at the molecular scale — electrons shared across atomic boundaries. The future of nano-engineering starts here.',
        'minimalist'  => 'Covalent bond. Shared electrons. Non-metals.',
        'storyteller' => 'The atoms, lonely on their own, reached across the void and shared their very electrons — forging a covalent bond, a union as old as the universe itself.',
        'lab_partner' => 'Oh right! It\'s a covalent bond — basically atoms sharing electrons, like sharing notes before a test 😄 Pretty cool huh?',
        _             => 'Interesting question! What do you think happens when atoms share electrons between two non-metals? 🤔',
      };

  String get botLabel {
    final m = current.value;
    return m != null ? '${m.iconAsset}  ${m.name.toUpperCase()}' : 'QUANTUM_BOT v4.2';
  }
}
