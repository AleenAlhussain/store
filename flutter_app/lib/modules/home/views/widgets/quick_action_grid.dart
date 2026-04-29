import 'package:flutter/material.dart';
import 'package:flutter_animate/flutter_animate.dart';

import '../../../../app/theme/app_colors.dart';

class _Action {
  final IconData icon;
  final String label;
  const _Action(this.icon, this.label);
}

const _actions = [
  _Action(Icons.quiz_outlined, 'DAILY QUIZ'),
  _Action(Icons.science_outlined, 'LAB'),
  _Action(Icons.style_outlined, 'CARDS'),
  _Action(Icons.psychology_outlined, 'AI HELP'),
];

class QuickActionGrid extends StatelessWidget {
  const QuickActionGrid({super.key});

  @override
  Widget build(BuildContext context) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: List.generate(
        _actions.length,
        (i) => _ActionItem(action: _actions[i], index: i),
      ),
    );
  }
}

class _ActionItem extends StatelessWidget {
  final _Action action;
  final int index;
  const _ActionItem({required this.action, required this.index});

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        GestureDetector(
          onTap: () {},
          child: Container(
            width: 58,
            height: 58,
            decoration: BoxDecoration(
              color: AppColors.bgCard,
              borderRadius: BorderRadius.circular(14),
              border: Border.all(color: AppColors.borderDefault),
            ),
            child: Icon(action.icon,
                color: AppColors.textSecondary, size: 22),
          ),
        ),
        const SizedBox(height: 6),
        Text(
          action.label,
          style: const TextStyle(
            color: AppColors.textMuted,
            fontSize: 9,
            letterSpacing: 0.8,
          ),
        ),
      ],
    )
        .animate(delay: Duration(milliseconds: 60 * index))
        .fadeIn(duration: 300.ms)
        .slideY(begin: 0.2, duration: 300.ms);
  }
}
