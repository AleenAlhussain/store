class QuizOption {
  final String letter;
  final String name;
  final String detail;

  const QuizOption({
    required this.letter,
    required this.name,
    this.detail = '',
  });
}

class QuizQuestion {
  final int number;
  final int total;
  final String category;
  final String question;
  final String keyword;
  final String birdHint;
  final String hint;
  final String hintSymbol;
  final List<QuizOption> options;
  final String correctLetter;
  final String configLabel;

  const QuizQuestion({
    required this.number,
    required this.total,
    required this.category,
    required this.question,
    required this.birdHint,
    required this.options,
    required this.correctLetter,
    this.keyword = '',
    this.hint = '',
    this.hintSymbol = '',
    this.configLabel = '',
  });

  static List<QuizQuestion> get defaults => const [
        QuizQuestion(
          number: 4,
          total: 10,
          category: 'ATOMIC BONDING',
          question:
              'Which of these elements is most likely to form a Covalent Bond with Oxygen?',
          keyword: 'Covalent Bond',
          birdHint:
              "You're doing great! This one is all about how atoms stick together. Think about shared electrons!",
          hint: 'Covalent bonds form between non-metals sharing electrons.',
          hintSymbol: 'O',
          options: [
            QuizOption(letter: 'A', name: 'Sodium (Na)'),
            QuizOption(letter: 'B', name: 'Carbon (C)'),
            QuizOption(letter: 'C', name: 'Magnesium (Mg)'),
            QuizOption(letter: 'D', name: 'Potassium (K)'),
          ],
          correctLetter: 'B',
          configLabel: 'C: [He] 2s² 2p²',
        ),
        QuizQuestion(
          number: 5,
          total: 10,
          category: 'PERIODIC TABLE',
          question:
              'What is the Atomic Number of the element Carbon?',
          keyword: 'Atomic Number',
          birdHint:
              'Atomic number tells us how many protons are in the nucleus. Carbon is in Period 2!',
          hint: 'Carbon is the backbone of all organic chemistry.',
          hintSymbol: 'C',
          options: [
            QuizOption(letter: 'A', name: '4'),
            QuizOption(letter: 'B', name: '6'),
            QuizOption(letter: 'C', name: '8'),
            QuizOption(letter: 'D', name: '12'),
          ],
          correctLetter: 'B',
          configLabel: 'C: [He] 2s² 2p²',
        ),
        QuizQuestion(
          number: 6,
          total: 10,
          category: 'CHEMICAL REACTIONS',
          question:
              'What type of reaction releases energy in the form of heat?',
          keyword: 'releases energy',
          birdHint:
              'Think about hand warmers — they get hot when they react. That release is the key!',
          hint: 'Think about what happens with burning or hand warmers.',
          hintSymbol: '🔥',
          options: [
            QuizOption(letter: 'A', name: 'Endothermic'),
            QuizOption(letter: 'B', name: 'Decomposition'),
            QuizOption(letter: 'C', name: 'Exothermic'),
            QuizOption(letter: 'D', name: 'Neutralization'),
          ],
          correctLetter: 'C',
          configLabel: 'ΔH < 0 (negative)',
        ),
      ];
}
