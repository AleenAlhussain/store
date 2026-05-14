import 'package:flutter/material.dart';
import 'package:get/get.dart';

import '../../../app/theme/app_colors.dart';
import '../../../core/controllers/theme_controller.dart';
import '../../companion/views/companion_view.dart';
import '../../flashcards/views/flashcards_view.dart';
import '../../home/views/home_view.dart';
import '../../lessons/views/lessons_view.dart';
import '../../pilot_profile/views/pilot_profile_view.dart';
import '../controllers/main_nav_controller.dart';

class MainNavView extends GetView<MainNavController> {
  const MainNavView({super.key});

  // Non-const so Flutter rebuilds children when the theme changes.
  static List<Widget> get _pages => [
        HomeView(),
        LessonsView(),
        CompanionView(),
        FlashcardsView(),
        PilotProfileView(),
      ];

  @override
  Widget build(BuildContext context) {
    final tc = Get.find<ThemeController>();
    return Obx(() {
      tc.variant.value; // subscribe — triggers full rebuild on theme change
      return Scaffold(
        backgroundColor: AppColors.bgBase,
        body: IndexedStack(
          index: controller.currentIndex.value,
          children: _pages,
        ),
        bottomNavigationBar: _QuantumNavBar(
          currentIndex: controller.currentIndex.value,
          onTap: controller.changeTab,
        ),
      );
    });
  }
}

// ── Bottom navigation bar ─────────────────────────────────────────────────────

class _QuantumNavBar extends StatelessWidget {
  final int currentIndex;
  final ValueChanged<int> onTap;

  const _QuantumNavBar({required this.currentIndex, required this.onTap});

  // Items for positions 0,1 and 3,4 — position 2 is the special center button.
  static const _sideItems = [
    (idx: 0, icon: Icons.home_outlined, label: 'Home'),
    (idx: 1, icon: Icons.menu_book_outlined, label: 'Topics'),
    (idx: 3, icon: Icons.bar_chart_rounded, label: 'Progress'),
    (idx: 4, icon: Icons.person_outline, label: 'Profile'),
  ];

  @override
  Widget build(BuildContext context) {
    return Container(
      height: 72 + MediaQuery.of(context).padding.bottom,
      margin: const EdgeInsets.fromLTRB(16, 0, 16, 12),
      decoration: BoxDecoration(
        color: AppColors.bgCard,
        borderRadius: BorderRadius.circular(24),
        border: Border.all(color: AppColors.borderDefault),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.3),
            blurRadius: 20,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceAround,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          // HOME
          _NavItem(
              icon: _sideItems[0].icon,
              label: _sideItems[0].label,
              isActive: currentIndex == 0,
              onTap: () => onTap(0)),
          // LESSONS
          _NavItem(
              icon: _sideItems[1].icon,
              label: _sideItems[1].label,
              isActive: currentIndex == 1,
              onTap: () => onTap(1)),
          // CENTER — companion button
          _CompanionNavButton(
              isActive: currentIndex == 2, onTap: () => onTap(2)),
          // LAB
          _NavItem(
              icon: _sideItems[2].icon,
              label: _sideItems[2].label,
              isActive: currentIndex == 3,
              onTap: () => onTap(3)),
          // PROFILE
          _NavItem(
              icon: _sideItems[3].icon,
              label: _sideItems[3].label,
              isActive: currentIndex == 4,
              onTap: () => onTap(4)),
        ],
      ),
    );
  }
}

class _NavItem extends StatelessWidget {
  final IconData icon;
  final String label;
  final bool isActive;
  final VoidCallback onTap;

  const _NavItem({
    required this.icon,
    required this.label,
    required this.isActive,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      behavior: HitTestBehavior.opaque,
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 200),
        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 10),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Icon(icon,
                size: 22,
                color: isActive ? AppColors.purple : AppColors.textMuted),
            const SizedBox(height: 4),
            Text(
              label,
              style: TextStyle(
                color: isActive ? AppColors.purple : AppColors.textMuted,
                fontSize: 9,
                letterSpacing: 0.2,
                fontWeight: isActive ? FontWeight.w700 : FontWeight.w400,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

// The special center companion button — elevated circle with glow.
class _CompanionNavButton extends StatelessWidget {
  final bool isActive;
  final VoidCallback onTap;

  const _CompanionNavButton({required this.isActive, required this.onTap});

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      behavior: HitTestBehavior.opaque,
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          AnimatedContainer(
            duration: const Duration(milliseconds: 220),
            width: 50,
            height: 50,
            decoration: BoxDecoration(
              shape: BoxShape.circle,
              color: isActive ? AppColors.purple : AppColors.purpleDim,
              boxShadow: isActive
                  ? [
                      BoxShadow(
                        color: AppColors.purple.withOpacity(0.45),
                        blurRadius: 16,
                        spreadRadius: 1,
                        offset: const Offset(0, 3),
                      ),
                    ]
                  : [],
            ),
            child: Icon(
              Icons.smart_toy_rounded,
              size: 24,
              color: isActive ? Colors.white : AppColors.purple,
            ),
          ),
          const SizedBox(height: 4),
          Text(
            'Tutor',
            style: TextStyle(
              color: isActive ? AppColors.purple : AppColors.textMuted,
              fontSize: 8,
              letterSpacing: 0.8,
              fontWeight: isActive ? FontWeight.w700 : FontWeight.w400,
            ),
          ),
        ],
      ),
    );
  }
}
