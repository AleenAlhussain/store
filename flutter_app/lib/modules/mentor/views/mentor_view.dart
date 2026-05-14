import 'package:flutter/material.dart';
import 'package:flutter_animate/flutter_animate.dart';
import 'package:get/get.dart';

import '../../../app/theme/app_colors.dart';
import '../controllers/mentor_controller.dart';
import 'widgets/mentor_card.dart';

class MentorView extends GetView<MentorController> {
  const MentorView({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.bgBase,
      body: Column(
        children: [
          // ── Header ────────────────────────────────────────────────────
          SafeArea(
            bottom: false,
            child: Padding(
              padding: const EdgeInsets.fromLTRB(24, 24, 24, 0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  Text(
                    'Welcome, Future\nScientist!',
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: AppColors.purple,
                      fontSize: 28,
                      fontWeight: FontWeight.w800,
                      height: 1.2,
                    ),
                  ).animate().fadeIn(duration: 400.ms).slideY(begin: 0.2),
                  const SizedBox(height: 10),
                  Text(
                    'Choose your personal AI guide to begin\nyour amazing chemistry journey today!',
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: AppColors.textSecondary,
                      fontSize: 13,
                      height: 1.5,
                    ),
                  ).animate().fadeIn(delay: 100.ms, duration: 400.ms),
                ],
              ),
            ),
          ),

          const SizedBox(height: 18),

          // ── Mentor list ───────────────────────────────────────────────
          Expanded(
            child: Obx(() => ListView.separated(
                  padding: const EdgeInsets.symmetric(horizontal: 20),
                  itemCount: controller.mentors.length,
                  separatorBuilder: (_, __) => const SizedBox(height: 14),
                  itemBuilder: (_, i) {
                    final m = controller.mentors[i];
                    return Obx(() => MentorCard(
                          mentor: m,
                          isSelected: controller.isSelected(m.id),
                          onTap: () => controller.select(m.id),
                          index: i,
                        ));
                  },
                )),
          ),

          // ── CTA ───────────────────────────────────────────────────────
          Container(
            color: AppColors.bgBase,
            padding: EdgeInsets.fromLTRB(
                20, 14, 20, 14 + MediaQuery.of(context).padding.bottom),
            child: Column(
              children: [
                SizedBox(
                  width: double.infinity,
                  child: Obx(() => ElevatedButton(
                        onPressed: controller.isLoading.value
                            ? null
                            : controller.initializeSession,
                        style: ElevatedButton.styleFrom(
                          backgroundColor: AppColors.purple,
                          padding: const EdgeInsets.symmetric(vertical: 17),
                          shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(30)),
                          elevation: 0,
                        ),
                        child: controller.isLoading.value
                            ? const SizedBox(
                                width: 22,
                                height: 22,
                                child: CircularProgressIndicator(
                                    color: Colors.white, strokeWidth: 2),
                              )
                            : Row(
                                mainAxisAlignment: MainAxisAlignment.center,
                                children: const [
                                  Text(
                                    'Start Learning',
                                    style: TextStyle(
                                      fontSize: 16,
                                      fontWeight: FontWeight.w800,
                                      color: Colors.white,
                                    ),
                                  ),
                                  SizedBox(width: 8),
                                  Icon(Icons.arrow_forward_rounded,
                                      color: Colors.white, size: 18),
                                ],
                              ),
                      )),
                ),
                const SizedBox(height: 10),
                Text(
                  'SMART  •  FRIENDLY  •  ALWAYS HERE',
                  style: TextStyle(
                    color: AppColors.textMuted,
                    fontSize: 10,
                    letterSpacing: 1.5,
                    fontWeight: FontWeight.w600,
                  ),
                ),
                const SizedBox(height: 10),
                // Topic chips
                Wrap(
                  spacing: 8,
                  runSpacing: 6,
                  alignment: WrapAlignment.center,
                  children: const [
                    _TopicChip('🔬', 'Atomic Structure'),
                    _TopicChip('⚛️', 'Chemical Bonding'),
                    _TopicChip('🧪', 'Reactions'),
                    _TopicChip('⚖️', 'Stoichiometry'),
                  ],
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}

class _TopicChip extends StatelessWidget {
  final String emoji;
  final String label;
  const _TopicChip(this.emoji, this.label);

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 5),
      decoration: BoxDecoration(
        color: AppColors.purpleDim,
        borderRadius: BorderRadius.circular(20),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Text(emoji, style: const TextStyle(fontSize: 12)),
          const SizedBox(width: 4),
          Text(
            label,
            style: TextStyle(
              color: AppColors.purple,
              fontSize: 11,
              fontWeight: FontWeight.w600,
            ),
          ),
        ],
      ),
    );
  }
}
