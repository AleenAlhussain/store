import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../../app/theme/app_colors.dart';
import '../../../core/controllers/theme_controller.dart';
import '../../../widgets/flask_logo.dart';
import '../controllers/pilot_profile_controller.dart';

class PilotProfileView extends GetView<PilotProfileController> {
  const PilotProfileView({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.bgBase,
      appBar: AppBar(
        backgroundColor: AppColors.bgBase,
        titleSpacing: 16,
        leading: Padding(
          padding: const EdgeInsets.all(10),
          child: Container(
            decoration: BoxDecoration(
              shape: BoxShape.circle,
              color: AppColors.bgCard,
              border: Border.all(color: AppColors.borderDefault),
            ),
            child: const Icon(Icons.person_outline,
                color: AppColors.textSecondary, size: 18),
          ),
        ),
        title: const Text(
          'PILOT PROFILE',
          style: TextStyle(
            color: AppColors.textPrimary,
            fontSize: 12,
            fontWeight: FontWeight.w700,
            letterSpacing: 1.8,
          ),
        ),
        actions: [
          IconButton(
            icon: const Icon(Icons.settings_outlined,
                color: AppColors.textSecondary, size: 20),
            onPressed: () {},
          ),
        ],
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 20),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            // ── Avatar + level badge ───────────────────────────────────
            Stack(
              alignment: Alignment.bottomCenter,
              children: [
                Container(
                  width: 90,
                  height: 90,
                  decoration: BoxDecoration(
                    shape: BoxShape.circle,
                    color: AppColors.bgCard,
                    border: Border.all(
                        color: AppColors.purple.withOpacity(0.6),
                        width: 2.5),
                    boxShadow: [
                      BoxShadow(
                        color: AppColors.purple.withOpacity(0.25),
                        blurRadius: 20,
                        spreadRadius: 2,
                      ),
                    ],
                  ),
                  child: ClipOval(
                    child: Padding(
                      padding: const EdgeInsets.all(10),
                      child: FlaskLogo(size: 60),
                    ),
                  ),
                ),
                Positioned(
                  bottom: -4,
                  child: Container(
                    padding:
                        const EdgeInsets.symmetric(horizontal: 10, vertical: 3),
                    decoration: BoxDecoration(
                      color: const Color(0xFFFBBF24),
                      borderRadius: BorderRadius.circular(12),
                      boxShadow: [
                        BoxShadow(
                          color: const Color(0xFFFBBF24).withOpacity(0.4),
                          blurRadius: 8,
                        ),
                      ],
                    ),
                    child: Text(
                      'LVL ${controller.level}',
                      style: const TextStyle(
                        color: Colors.white,
                        fontSize: 10,
                        fontWeight: FontWeight.w800,
                        letterSpacing: 0.5,
                      ),
                    ),
                  ),
                ),
              ],
            ),

            const SizedBox(height: 20),

            // ── Name + rank ────────────────────────────────────────────
            Text(
              controller.name,
              style: const TextStyle(
                color: AppColors.textPrimary,
                fontSize: 22,
                fontWeight: FontWeight.w800,
              ),
            ),
            const SizedBox(height: 4),
            Text(
              controller.rank,
              style: const TextStyle(
                color: AppColors.purple,
                fontSize: 11,
                fontWeight: FontWeight.w700,
                letterSpacing: 3,
              ),
            ),

            const SizedBox(height: 24),

            // ── Subscription card ──────────────────────────────────────
            GestureDetector(
              onTap: () {},
              child: Container(
                padding: const EdgeInsets.all(16),
                decoration: BoxDecoration(
                  color: AppColors.bgCard,
                  borderRadius: BorderRadius.circular(14),
                  border: Border.all(
                      color: const Color(0xFFFBBF24).withOpacity(0.3)),
                ),
                child: Row(
                  children: [
                    Container(
                      width: 40,
                      height: 40,
                      decoration: BoxDecoration(
                        color: const Color(0xFFFBBF24).withOpacity(0.15),
                        borderRadius: BorderRadius.circular(10),
                      ),
                      child: const Icon(
                        Icons.workspace_premium_rounded,
                        color: Color(0xFFFBBF24),
                        size: 22,
                      ),
                    ),
                    const SizedBox(width: 14),
                    Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            controller.planName,
                            style: const TextStyle(
                              color: AppColors.textPrimary,
                              fontSize: 14,
                              fontWeight: FontWeight.w700,
                            ),
                          ),
                          const SizedBox(height: 2),
                          Text(
                            controller.planExpiry,
                            style: const TextStyle(
                              color: AppColors.textSecondary,
                              fontSize: 12,
                            ),
                          ),
                        ],
                      ),
                    ),
                    const Icon(Icons.chevron_right,
                        color: AppColors.textSecondary),
                  ],
                ),
              ),
            ),

            const SizedBox(height: 24),

            // ── Settings section ───────────────────────────────────────
            Align(
              alignment: Alignment.centerLeft,
              child: const Text(
                'Mission Parameters',
                style: TextStyle(
                  color: AppColors.textMuted,
                  fontSize: 11,
                  letterSpacing: 0.5,
                ),
              ),
            ),

            const SizedBox(height: 10),

            Obx(() => Container(
                  decoration: BoxDecoration(
                    color: AppColors.bgCard,
                    borderRadius: BorderRadius.circular(14),
                    border: Border.all(color: AppColors.borderDefault),
                  ),
                  child: Column(
                    children: List.generate(
                      controller.settings.length,
                      (i) {
                        final s = controller.settings[i];
                        final isLast = i == controller.settings.length - 1;
                        return _SettingsRow(
                          icon: _iconFor(s.icon),
                          label: s.label,
                          trailing: s.trailing,
                          showDivider: !isLast,
                          onTap: s.icon == 'theme'
                              ? () => Get.bottomSheet(
                                    const _ThemePickerSheet(),
                                    isScrollControlled: true,
                                    backgroundColor: Colors.transparent,
                                  )
                              : () => controller.handleSettingTap(s.icon),
                        );
                      },
                    ),
                  ),
                )),

            const SizedBox(height: 32),

            // ── Disconnect button ──────────────────────────────────────
            GestureDetector(
              onTap: controller.disconnect,
              child: Container(
                width: double.infinity,
                padding: const EdgeInsets.symmetric(vertical: 16),
                decoration: BoxDecoration(
                  color: const Color(0xFFEF4444).withOpacity(0.08),
                  borderRadius: BorderRadius.circular(14),
                  border: Border.all(
                      color: const Color(0xFFEF4444).withOpacity(0.35)),
                ),
                child: const Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Icon(Icons.logout_rounded,
                        color: Color(0xFFEF4444), size: 18),
                    SizedBox(width: 10),
                    Text(
                      'DISCONNECT SESSION',
                      style: TextStyle(
                        color: Color(0xFFEF4444),
                        fontSize: 13,
                        fontWeight: FontWeight.w700,
                        letterSpacing: 1.5,
                      ),
                    ),
                  ],
                ),
              ),
            ),

            const SizedBox(height: 16),

            Text(
              controller.version,
              style: const TextStyle(
                color: AppColors.textMuted,
                fontSize: 11,
              ),
            ),

            const SizedBox(height: 30),
          ],
        ),
      ),
    );
  }

  IconData _iconFor(String key) {
    return switch (key) {
      'account' => Icons.manage_accounts_outlined,
      'privacy' => Icons.shield_outlined,
      'alerts' => Icons.notifications_outlined,
      'theme' => Icons.palette_outlined,
      'mentor' => Icons.school_outlined,
      'support' => Icons.help_outline_rounded,
      _ => Icons.chevron_right,
    };
  }
}

class _SettingsRow extends StatelessWidget {
  final IconData icon;
  final String label;
  final String trailing;
  final bool showDivider;
  final VoidCallback onTap;

  const _SettingsRow({
    required this.icon,
    required this.label,
    required this.trailing,
    required this.showDivider,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        GestureDetector(
          onTap: onTap,
          child: Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14),
            child: Row(
              children: [
                Icon(icon, color: AppColors.textSecondary, size: 18),
                const SizedBox(width: 14),
                Expanded(
                  child: Text(
                    label,
                    style: const TextStyle(
                      color: AppColors.textPrimary,
                      fontSize: 14,
                    ),
                  ),
                ),
                if (trailing.isNotEmpty)
                  Padding(
                    padding: const EdgeInsets.only(right: 4),
                    child: Text(
                      trailing,
                      style: const TextStyle(
                        color: AppColors.purple,
                        fontSize: 13,
                        fontWeight: FontWeight.w600,
                      ),
                    ),
                  ),
                const Icon(Icons.chevron_right,
                    color: AppColors.textMuted, size: 18),
              ],
            ),
          ),
        ),
        if (showDivider)
          const Divider(
              height: 1,
              color: AppColors.borderDefault,
              indent: 48),
      ],
    );
  }
}

// ── Theme picker bottom sheet ─────────────────────────────────────────────────
class _ThemePickerSheet extends StatelessWidget {
  const _ThemePickerSheet();

  static const _themes = [
    (
      variant: AppThemeVariant.quantum,
      emoji: '🌌',
      name: 'Quantum',
      sub: 'Dark mode',
      accent: Color(0xFF8B7DF8),
      bg: Color(0xFF0C0F2A),
    ),
    (
      variant: AppThemeVariant.luna,
      emoji: '🌸',
      name: 'Luna',
      sub: 'For girls',
      accent: Color(0xFFEC4899),
      bg: Color(0xFFFFF5FA),
    ),
    (
      variant: AppThemeVariant.milo,
      emoji: '🌿',
      name: 'Milo',
      sub: 'For boys',
      accent: Color(0xFF16A34A),
      bg: Color(0xFFF5FFF7),
    ),
    (
      variant: AppThemeVariant.sunny,
      emoji: '☀️',
      name: 'Sunny',
      sub: 'Loves to explain',
      accent: Color(0xFFD97706),
      bg: Color(0xFFFFFDF0),
    ),
  ];

  @override
  Widget build(BuildContext context) {
    final tc = Get.find<ThemeController>();
    return Container(
      decoration: BoxDecoration(
        color: AppColors.bgCard,
        borderRadius: const BorderRadius.vertical(top: Radius.circular(24)),
        border: Border.all(color: AppColors.borderDefault),
      ),
      padding: const EdgeInsets.fromLTRB(24, 16, 24, 32),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          // Handle bar
          Container(
            width: 40,
            height: 4,
            decoration: BoxDecoration(
              color: AppColors.borderDefault,
              borderRadius: BorderRadius.circular(2),
            ),
          ),
          const SizedBox(height: 20),
          Text(
            'CHOOSE THEME',
            style: TextStyle(
              color: AppColors.textPrimary,
              fontSize: 13,
              fontWeight: FontWeight.w800,
              letterSpacing: 2,
            ),
          ),
          const SizedBox(height: 6),
          Text(
            'Personalise your learning environment',
            style: TextStyle(color: AppColors.textSecondary, fontSize: 12),
          ),
          const SizedBox(height: 20),
          Obx(() {
            final current = tc.variant.value;
            return GridView.count(
              crossAxisCount: 2,
              shrinkWrap: true,
              physics: const NeverScrollableScrollPhysics(),
              mainAxisSpacing: 12,
              crossAxisSpacing: 12,
              childAspectRatio: 1.4,
              children: _themes.map((t) {
                final selected = current == t.variant;
                return GestureDetector(
                  onTap: () {
                    tc.setVariant(t.variant);
                    Get.back();
                  },
                  child: AnimatedContainer(
                    duration: const Duration(milliseconds: 200),
                    decoration: BoxDecoration(
                      color: t.bg,
                      borderRadius: BorderRadius.circular(16),
                      border: Border.all(
                        color: selected ? t.accent : t.bg,
                        width: 2.5,
                      ),
                      boxShadow: selected
                          ? [
                              BoxShadow(
                                color: t.accent.withOpacity(0.25),
                                blurRadius: 12,
                                spreadRadius: 1,
                              )
                            ]
                          : [],
                    ),
                    padding: const EdgeInsets.all(14),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Row(
                          children: [
                            Text(t.emoji,
                                style: const TextStyle(fontSize: 20)),
                            const Spacer(),
                            if (selected)
                              Container(
                                width: 18,
                                height: 18,
                                decoration: BoxDecoration(
                                  color: t.accent,
                                  shape: BoxShape.circle,
                                ),
                                child: const Icon(Icons.check,
                                    color: Colors.white, size: 12),
                              ),
                          ],
                        ),
                        const Spacer(),
                        Text(
                          t.name,
                          style: TextStyle(
                            color: t.accent,
                            fontSize: 14,
                            fontWeight: FontWeight.w800,
                          ),
                        ),
                        Text(
                          t.sub,
                          style: TextStyle(
                            color: t.accent.withOpacity(0.7),
                            fontSize: 11,
                          ),
                        ),
                      ],
                    ),
                  ),
                );
              }).toList(),
            );
          }),
        ],
      ),
    );
  }
}
