import 'package:flutter/material.dart';
import 'package:flutter_animate/flutter_animate.dart';
import 'package:get/get.dart';

import '../../../../app/theme/app_colors.dart';
import '../../../../core/controllers/theme_controller.dart';
import '../../../../widgets/mascot_bird.dart';

class MascotCard extends StatelessWidget {
  const MascotCard({super.key});

  static const _names = {
    AppThemeVariant.quantum: 'Tutor',
    AppThemeVariant.luna:    'Luna',
    AppThemeVariant.milo:    'Milo',
    AppThemeVariant.sunny:   'Sunny',
  };

  static const _messages = {
    AppThemeVariant.quantum: [
      'Ready to explore quantum chemistry today?',
      'The lab is open — what shall we discover?',
      'Every great scientist started with a question.',
      'Electrons are waiting. Let\'s dive in!',
      'One lesson a day keeps confusion away.',
      'Your next breakthrough is one study session away!',
    ],
    AppThemeVariant.luna: [
      'Hi! Let\'s make chemistry fun and easy today! ✨',
      'Chemistry is magical — just like you! 🌸',
      'Ready to learn something amazing? 💕',
      'I believe in you! Every concept is within reach!',
      'Science and sparkle — the perfect combo! 🎀',
      'Let\'s turn those formulas into fairy tales! 🌟',
    ],
    AppThemeVariant.milo: [
      'Hey! Ready to solve some cool problems? 🧪',
      'Science is awesome — let\'s crush it today!',
      'Let\'s tackle chemistry together, team! 💪',
      'You\'ve got this! One lesson at a time.',
      'Challenge accepted. Let\'s go! ⚡',
      'Big brain energy — let\'s channel it into chemistry!',
    ],
    AppThemeVariant.sunny: [
      'I love explaining things — ask me anything! ☀️',
      'Every concept is a story waiting to be told!',
      'Learning is the greatest adventure. Let\'s explore!',
      'Sunshine + Chemistry = Pure Magic! ✨',
      'No question is too small — curiosity wins!',
      'Today\'s lesson is tomorrow\'s superpower!',
    ],
  };

  String _message(AppThemeVariant v) {
    final msgs = _messages[v]!;
    // Rotate messages based on day + hour block so it feels fresh
    final idx = (DateTime.now().day * 4 + DateTime.now().hour ~/ 6) % msgs.length;
    return msgs[idx];
  }

  @override
  Widget build(BuildContext context) {
    return Obx(() {
      final v = Get.find<ThemeController>().variant.value;
      final name = _names[v]!;

      return Container(
        padding: const EdgeInsets.fromLTRB(16, 14, 6, 14),
        decoration: BoxDecoration(
          color: AppColors.bgCard,
          borderRadius: BorderRadius.circular(20),
          border: Border.all(color: AppColors.borderDefault),
          boxShadow: [
            BoxShadow(
              color: AppColors.purple.withOpacity(0.09),
              blurRadius: 18,
              offset: const Offset(0, 4),
            ),
          ],
        ),
        child: Row(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            // Text side
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Name + badge
                  Row(
                    children: [
                      Text(
                        name,
                        style: TextStyle(
                          color: AppColors.purple,
                          fontSize: 15,
                          fontWeight: FontWeight.w800,
                          letterSpacing: 0.3,
                        ),
                      ),
                      const SizedBox(width: 8),
                      Container(
                        padding: const EdgeInsets.symmetric(
                            horizontal: 7, vertical: 2),
                        decoration: BoxDecoration(
                          color: AppColors.purpleDim,
                          borderRadius: BorderRadius.circular(6),
                        ),
                        child: Text(
                          'AI GUIDE',
                          style: TextStyle(
                            color: AppColors.purple,
                            fontSize: 8,
                            fontWeight: FontWeight.w700,
                            letterSpacing: 1.0,
                          ),
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 7),
                  // Message
                  Text(
                    _message(v),
                    style: TextStyle(
                      color: AppColors.textPrimary,
                      fontSize: 13,
                      height: 1.45,
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(width: 4),
            // Bird character
            MascotBird(variant: v, size: 86),
          ],
        ),
      )
          .animate()
          .fadeIn(duration: 350.ms)
          .slideY(begin: 0.08, duration: 350.ms, curve: Curves.easeOut);
    });
  }
}
