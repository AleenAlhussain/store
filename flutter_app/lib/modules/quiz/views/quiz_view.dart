import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../../app/theme/app_colors.dart';
import '../../../core/controllers/theme_controller.dart';
import '../../../widgets/mascot_bird.dart';
import '../controllers/quiz_controller.dart';

class QuizView extends GetView<QuizController> {
  const QuizView({super.key});

  @override
  Widget build(BuildContext context) {
    final variant = Get.find<ThemeController>().variant.value;
    return Scaffold(
      backgroundColor: AppColors.bgBase,
      appBar: _buildAppBar(),
      body: Obx(() {
        final q = controller.current;
        return Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // ── Progress header ──────────────────────────────────────────
            Padding(
              padding: const EdgeInsets.fromLTRB(18, 14, 18, 0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Text(
                        'Question ${q.number} of ${q.total}',
                        style: TextStyle(
                          color: AppColors.purple,
                          fontSize: 14,
                          fontWeight: FontWeight.w700,
                        ),
                      ),
                      Text(
                        'Level 5',
                        style: const TextStyle(
                          color: AppColors.textSecondary,
                          fontSize: 14,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 8),
                  ClipRRect(
                    borderRadius: BorderRadius.circular(6),
                    child: LinearProgressIndicator(
                      value: q.number / q.total,
                      minHeight: 8,
                      backgroundColor: AppColors.purpleDim,
                      color: AppColors.purple,
                    ),
                  ),
                  const SizedBox(height: 16),
                  // Bird hint
                  _BirdHintRow(hint: q.birdHint, variant: variant),
                  const SizedBox(height: 8),
                ],
              ),
            ),

            // ── Scrollable question + answers ────────────────────────────
            Expanded(
              child: SingleChildScrollView(
                padding: const EdgeInsets.symmetric(horizontal: 18, vertical: 12),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // Question card
                    Container(
                      width: double.infinity,
                      padding: const EdgeInsets.all(20),
                      decoration: BoxDecoration(
                        color: AppColors.bgCard,
                        borderRadius: BorderRadius.circular(20),
                        boxShadow: [
                          BoxShadow(
                            color: Colors.black.withOpacity(0.06),
                            blurRadius: 16,
                            offset: const Offset(0, 4),
                          ),
                        ],
                      ),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Row(
                            children: [
                              Icon(Icons.science_outlined,
                                  color: AppColors.textMuted, size: 14),
                              const SizedBox(width: 6),
                              Text(
                                q.category,
                                style: TextStyle(
                                  color: AppColors.textMuted,
                                  fontSize: 11,
                                  fontWeight: FontWeight.w700,
                                  letterSpacing: 1.2,
                                ),
                              ),
                            ],
                          ),
                          const SizedBox(height: 12),
                          _buildQuestionText(q.question, q.keyword),
                        ],
                      ),
                    ),

                    const SizedBox(height: 16),

                    // Answer options (vertical list)
                    Obx(() => Column(
                          children: q.options.map((opt) {
                            final selected =
                                controller.selectedOption.value == opt.letter;
                            final isSubmitted = controller.submitted.value;
                            final correct = opt.letter == q.correctLetter;

                            Color bg;
                            Color border;
                            Color textColor;
                            Color letterBg;
                            Color letterText;

                            if (!isSubmitted) {
                              bg = selected ? AppColors.purple : AppColors.bgCard;
                              border = selected ? AppColors.purple : AppColors.borderDefault;
                              textColor = selected ? Colors.white : AppColors.textPrimary;
                              letterBg = selected
                                  ? Colors.white.withOpacity(0.2)
                                  : AppColors.purpleDim;
                              letterText = selected ? Colors.white : AppColors.purple;
                            } else if (correct) {
                              bg = AppColors.green.withOpacity(0.12);
                              border = AppColors.green;
                              textColor = AppColors.textPrimary;
                              letterBg = AppColors.green.withOpacity(0.2);
                              letterText = AppColors.green;
                            } else if (selected) {
                              bg = Colors.red.shade50;
                              border = Colors.red.shade400;
                              textColor = AppColors.textPrimary;
                              letterBg = Colors.red.shade100;
                              letterText = Colors.red.shade400;
                            } else {
                              bg = AppColors.bgCard;
                              border = AppColors.borderDefault;
                              textColor = AppColors.textSecondary;
                              letterBg = AppColors.purpleDim;
                              letterText = AppColors.textMuted;
                            }

                            return Padding(
                              padding: const EdgeInsets.only(bottom: 10),
                              child: GestureDetector(
                                onTap: () => controller.selectOption(opt.letter),
                                child: AnimatedContainer(
                                  duration: const Duration(milliseconds: 250),
                                  width: double.infinity,
                                  padding: const EdgeInsets.symmetric(
                                      horizontal: 16, vertical: 16),
                                  decoration: BoxDecoration(
                                    color: bg,
                                    borderRadius: BorderRadius.circular(16),
                                    border: Border.all(color: border, width: 1.5),
                                    boxShadow: [
                                      BoxShadow(
                                        color: Colors.black.withOpacity(0.04),
                                        blurRadius: 8,
                                        offset: const Offset(0, 2),
                                      ),
                                    ],
                                  ),
                                  child: Row(
                                    children: [
                                      Container(
                                        width: 36,
                                        height: 36,
                                        decoration: BoxDecoration(
                                          shape: BoxShape.circle,
                                          color: letterBg,
                                        ),
                                        alignment: Alignment.center,
                                        child: isSubmitted && correct
                                            ? Icon(Icons.check_rounded,
                                                color: AppColors.green, size: 18)
                                            : Text(
                                                opt.letter,
                                                style: TextStyle(
                                                  color: letterText,
                                                  fontSize: 14,
                                                  fontWeight: FontWeight.w800,
                                                ),
                                              ),
                                      ),
                                      const SizedBox(width: 14),
                                      Text(
                                        opt.name,
                                        style: TextStyle(
                                          color: textColor,
                                          fontSize: 16,
                                          fontWeight: FontWeight.w600,
                                        ),
                                      ),
                                    ],
                                  ),
                                ),
                              ),
                            );
                          }).toList(),
                        )),

                    const SizedBox(height: 10),
                  ],
                ),
              ),
            ),
          ],
        );
      }),

      // ── Submit button (fixed at bottom) ──────────────────────────────────
      bottomNavigationBar: Obx(() {
        final canSubmit = controller.selectedOption.value != null &&
            !controller.submitted.value;
        return Container(
          padding: EdgeInsets.fromLTRB(
              18, 12, 18, 12 + MediaQuery.of(context).padding.bottom),
          color: AppColors.bgBase,
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              SizedBox(
                width: double.infinity,
                child: AnimatedOpacity(
                  opacity: canSubmit ? 1.0 : 0.5,
                  duration: const Duration(milliseconds: 200),
                  child: ElevatedButton(
                    onPressed: canSubmit ? controller.submitAnswer : null,
                    style: ElevatedButton.styleFrom(
                      backgroundColor: AppColors.purple,
                      disabledBackgroundColor: AppColors.purple,
                      padding: const EdgeInsets.symmetric(vertical: 18),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(30),
                      ),
                      elevation: 0,
                    ),
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: const [
                        Text(
                          'Submit Answer',
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 16,
                            fontWeight: FontWeight.w800,
                          ),
                        ),
                        SizedBox(width: 8),
                        Icon(Icons.arrow_forward_rounded,
                            color: Colors.white, size: 18),
                      ],
                    ),
                  ),
                ),
              ),
              const SizedBox(height: 6),
              Text(
                'TAP TO CONFIRM YOUR CHOICE',
                style: TextStyle(
                  color: AppColors.textMuted,
                  fontSize: 10,
                  letterSpacing: 1.2,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ],
          ),
        );
      }),
    );
  }

  Widget _buildQuestionText(String question, String keyword) {
    if (keyword.isEmpty) {
      return Text(
        question,
        style: TextStyle(
          color: AppColors.textPrimary,
          fontSize: 18,
          fontWeight: FontWeight.w700,
          height: 1.5,
        ),
      );
    }

    final idx = question.toLowerCase().indexOf(keyword.toLowerCase());
    if (idx == -1) {
      return Text(question,
          style: TextStyle(
              color: AppColors.textPrimary, fontSize: 18, fontWeight: FontWeight.w700, height: 1.5));
    }

    return RichText(
      text: TextSpan(
        style: TextStyle(
          color: AppColors.textPrimary,
          fontSize: 18,
          fontWeight: FontWeight.w700,
          height: 1.5,
        ),
        children: [
          TextSpan(text: question.substring(0, idx)),
          TextSpan(
            text: question.substring(idx, idx + keyword.length),
            style: TextStyle(color: AppColors.purple),
          ),
          TextSpan(text: question.substring(idx + keyword.length)),
        ],
      ),
    );
  }

  PreferredSizeWidget _buildAppBar() {
    return AppBar(
      backgroundColor: AppColors.bgBase,
      elevation: 0,
      leadingWidth: 48,
      leading: IconButton(
        icon: Icon(Icons.menu_rounded, color: AppColors.textPrimary, size: 24),
        onPressed: () => Get.back(),
      ),
      title: Text(
        'AI Chemistry Tutor',
        style: TextStyle(
          color: AppColors.purple,
          fontSize: 18,
          fontWeight: FontWeight.w800,
        ),
      ),
      actions: [
        Obx(() => Container(
              margin: const EdgeInsets.only(right: 8),
              padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
              decoration: BoxDecoration(
                color: AppColors.green.withOpacity(0.15),
                borderRadius: BorderRadius.circular(20),
                border: Border.all(color: AppColors.green.withOpacity(0.3)),
              ),
              child: Row(
                mainAxisSize: MainAxisSize.min,
                children: [
                  Icon(Icons.star_rounded, color: AppColors.green, size: 16),
                  const SizedBox(width: 4),
                  Text(
                    '${controller.score.value}',
                    style: TextStyle(
                      color: AppColors.green,
                      fontSize: 13,
                      fontWeight: FontWeight.w800,
                    ),
                  ),
                ],
              ),
            )),
        IconButton(
          icon: Icon(Icons.notifications_outlined,
              color: AppColors.textSecondary, size: 22),
          onPressed: () {},
        ),
      ],
    );
  }
}

// ── Bird hint row ─────────────────────────────────────────────────────────────

class _BirdHintRow extends StatelessWidget {
  final String hint;
  final AppThemeVariant variant;

  const _BirdHintRow({required this.hint, required this.variant});

  @override
  Widget build(BuildContext context) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        // Bird avatar circle
        Container(
          width: 52,
          height: 52,
          decoration: BoxDecoration(
            shape: BoxShape.circle,
            color: AppColors.purpleDim,
            border: Border.all(color: AppColors.purple.withOpacity(0.4), width: 2),
          ),
          child: ClipOval(child: MascotBird(variant: variant, size: 44)),
        ),
        const SizedBox(width: 10),
        // Speech bubble
        Expanded(
          child: Container(
            padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 11),
            decoration: BoxDecoration(
              color: AppColors.bgCard,
              borderRadius: const BorderRadius.only(
                topLeft: Radius.circular(4),
                topRight: Radius.circular(16),
                bottomLeft: Radius.circular(16),
                bottomRight: Radius.circular(16),
              ),
              border: Border.all(color: AppColors.purple.withOpacity(0.2)),
              boxShadow: [
                BoxShadow(
                  color: AppColors.purple.withOpacity(0.08),
                  blurRadius: 10,
                  offset: const Offset(0, 2),
                ),
              ],
            ),
            child: Text(
              '"$hint"',
              style: TextStyle(
                color: AppColors.textSecondary,
                fontSize: 12.5,
                height: 1.5,
                fontStyle: FontStyle.italic,
              ),
            ),
          ),
        ),
      ],
    );
  }
}
