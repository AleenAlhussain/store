import '../../app/theme/app_colors.dart';

class MentorModel {
  final String id;
  final String name;
  final String role;
  final String description;
  final String iconAsset;

  const MentorModel({
    required this.id,
    required this.name,
    required this.description,
    required this.iconAsset,
    this.role = '',
  });

  AppThemeVariant get themeVariant => switch (id) {
        'luna'  => AppThemeVariant.luna,
        'milo'  => AppThemeVariant.milo,
        'sunny' => AppThemeVariant.sunny,
        _       => AppThemeVariant.quantum,
      };

  factory MentorModel.fromJson(Map<String, dynamic> j) => MentorModel(
        id: j['id'] as String,
        name: j['name'] as String,
        role: j['role'] as String? ?? '',
        description: j['description'] as String,
        iconAsset: j['icon'] as String? ?? '',
      );

  static List<MentorModel> get defaults => const [
        MentorModel(
          id: 'tutor',
          name: 'Tutor',
          role: 'The Expert',
          description:
              'Your wise AI Guide. Perfect for mastering complex equations and big concepts!',
          iconAsset: '🎓',
        ),
        MentorModel(
          id: 'luna',
          name: 'Luna',
          role: 'Fun & Curious',
          description:
              'Learning with Luna is like a game! She loves making chemistry feel like magic!',
          iconAsset: '🌸',
        ),
        MentorModel(
          id: 'milo',
          name: 'Milo',
          role: 'Problem Solver',
          description:
              "Milo is ready to solve cool problems with you! He's the ultimate lab partner.",
          iconAsset: '🎮',
        ),
        MentorModel(
          id: 'sunny',
          name: 'Sunny',
          role: 'The Explainer',
          description:
              "Sunny loves to explain things step-by-step. He's patient, bright, and always encouraging!",
          iconAsset: '☀️',
        ),
      ];
}
