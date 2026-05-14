import 'package:flutter/material.dart';
import 'package:flutter_animate/flutter_animate.dart';

import '../../../../app/theme/app_colors.dart';
import '../../../../data/models/mentor_model.dart';
import '../../../../widgets/mascot_bird.dart';

class MentorCard extends StatelessWidget {
  final MentorModel mentor;
  final bool isSelected;
  final VoidCallback onTap;
  final int index;

  const MentorCard({
    super.key,
    required this.mentor,
    required this.isSelected,
    required this.onTap,
    required this.index,
  });

  Color _accentFor(AppThemeVariant v) => switch (v) {
        AppThemeVariant.quantum => const Color(0xFF8B7DF8),
        AppThemeVariant.luna    => const Color(0xFFEC4899),
        AppThemeVariant.milo    => const Color(0xFF16A34A),
        AppThemeVariant.sunny   => const Color(0xFFD97706),
      };

  Color _bgFor(AppThemeVariant v) => switch (v) {
        AppThemeVariant.quantum => const Color(0xFFEDE9FF),
        AppThemeVariant.luna    => const Color(0xFFFFF0F8),
        AppThemeVariant.milo    => const Color(0xFFF0FFF4),
        AppThemeVariant.sunny   => const Color(0xFFFFFBEB),
      };

  @override
  Widget build(BuildContext context) {
    final v = mentor.themeVariant;
    final accent = _accentFor(v);
    final bg = _bgFor(v);

    return GestureDetector(
      onTap: onTap,
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 250),
        curve: Curves.easeOut,
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(22),
          border: Border.all(
            color: isSelected ? accent : accent.withOpacity(0.18),
            width: isSelected ? 2.5 : 1.5,
          ),
          boxShadow: [
            BoxShadow(
              color: isSelected
                  ? accent.withOpacity(0.20)
                  : Colors.black.withOpacity(0.05),
              blurRadius: isSelected ? 16 : 8,
              offset: const Offset(0, 4),
            ),
          ],
        ),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            // ── Coloured top section with bird ─────────────────────────
            Container(
              width: double.infinity,
              height: 130,
              decoration: BoxDecoration(
                color: bg,
                borderRadius: const BorderRadius.vertical(
                    top: Radius.circular(20)),
              ),
              child: Stack(
                alignment: Alignment.center,
                children: [
                  // Faint character initial watermark
                  Text(
                    mentor.name[0],
                    style: TextStyle(
                      color: accent.withOpacity(0.07),
                      fontSize: 110,
                      fontWeight: FontWeight.w900,
                    ),
                  ),
                  MascotBird(variant: v, size: 96),
                ],
              ),
            ),

            // ── Info section ──────────────────────────────────────────
            Padding(
              padding: const EdgeInsets.fromLTRB(18, 14, 18, 18),
              child: Column(
                children: [
                  Text(
                    mentor.name,
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: accent,
                      fontSize: 22,
                      fontWeight: FontWeight.w800,
                    ),
                  ),
                  const SizedBox(height: 6),
                  Container(
                    padding: const EdgeInsets.symmetric(
                        horizontal: 12, vertical: 4),
                    decoration: BoxDecoration(
                      color: accent.withOpacity(0.12),
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: Text(
                      mentor.role,
                      style: TextStyle(
                        color: accent,
                        fontSize: 11,
                        fontWeight: FontWeight.w700,
                      ),
                    ),
                  ),
                  const SizedBox(height: 10),
                  Text(
                    mentor.description,
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: const Color(0xFF6B7280),
                      fontSize: 13,
                      height: 1.5,
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      )
          .animate(delay: Duration(milliseconds: 80 * index))
          .fadeIn(duration: 450.ms)
          .slideY(begin: 0.12, duration: 450.ms, curve: Curves.easeOut),
    );
  }
}
