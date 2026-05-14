import 'package:flutter/material.dart';
import 'package:flutter_animate/flutter_animate.dart';
import 'package:get/get.dart';

import '../../../app/routes/app_routes.dart';
import '../../../app/theme/app_colors.dart';
import '../../../core/controllers/theme_controller.dart';
import '../../../widgets/mascot_bird.dart';
import '../controllers/home_controller.dart';

class HomeView extends GetView<HomeController> {
  const HomeView({super.key});

  String _rank(int level) {
    if (level <= 5) return 'ROOKIE';
    if (level <= 15) return 'APPRENTICE';
    if (level <= 25) return 'SCHOLAR';
    return 'VOYAGER';
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.bgBase,
      appBar: _buildAppBar(),
      body: Obx(() {
        final user = controller.user.value;
        if (user == null) {
          return Center(
              child: CircularProgressIndicator(color: AppColors.purple));
        }
        final v = Get.find<ThemeController>().variant.value;

        return SingleChildScrollView(
          padding: const EdgeInsets.symmetric(horizontal: 18, vertical: 16),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              _HeroCard(
                variant: v,
                level: user.level,
                rank: _rank(user.level),
              )
                  .animate()
                  .fadeIn(duration: 400.ms)
                  .slideY(begin: 0.08, duration: 400.ms, curve: Curves.easeOut),

              const SizedBox(height: 22),

              _ExploreTopics()
                  .animate()
                  .fadeIn(delay: 100.ms, duration: 400.ms)
                  .slideY(begin: 0.08, duration: 400.ms),

              const SizedBox(height: 18),

              _DailyChallengeCard(variant: v)
                  .animate()
                  .fadeIn(delay: 200.ms, duration: 400.ms)
                  .slideY(begin: 0.08, duration: 400.ms),

              const SizedBox(height: 18),

              _ProgressSection(progress: user.progressToNextLevel)
                  .animate()
                  .fadeIn(delay: 300.ms, duration: 400.ms)
                  .slideY(begin: 0.08, duration: 400.ms),

              const SizedBox(height: 30),
            ],
          ),
        );
      }),
    );
  }

  PreferredSizeWidget _buildAppBar() {
    return AppBar(
      backgroundColor: AppColors.bgBase,
      elevation: 0,
      leadingWidth: 48,
      leading: const Icon(Icons.menu_rounded, size: 24),
      title: Text(
        'AI Chemistry Tutor',
        style: TextStyle(
          color: AppColors.purple,
          fontSize: 18,
          fontWeight: FontWeight.w800,
        ),
      ),
      actions: [
        IconButton(
          icon: Icon(Icons.notifications_outlined,
              color: AppColors.textSecondary, size: 22),
          onPressed: () {},
        ),
      ],
    );
  }
}

// ── Hero card ─────────────────────────────────────────────────────────────────

class _HeroCard extends StatelessWidget {
  final AppThemeVariant variant;
  final int level;
  final String rank;

  const _HeroCard({
    required this.variant,
    required this.level,
    required this.rank,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(22),
      decoration: BoxDecoration(
        color: AppColors.bgCard,
        borderRadius: BorderRadius.circular(24),
        boxShadow: [
          BoxShadow(
            color: AppColors.purple.withOpacity(0.12),
            blurRadius: 20,
            offset: const Offset(0, 6),
          ),
        ],
      ),
      child: Column(
        children: [
          Container(
            width: 88,
            height: 88,
            decoration: BoxDecoration(
              shape: BoxShape.circle,
              color: AppColors.purpleDim,
              border: Border.all(color: AppColors.purple, width: 2.5),
              boxShadow: [
                BoxShadow(
                  color: AppColors.purple.withOpacity(0.30),
                  blurRadius: 18,
                  spreadRadius: 2,
                ),
              ],
            ),
            child: ClipOval(child: MascotBird(variant: variant, size: 76)),
          ),

          const SizedBox(height: 14),

          Container(
            padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 4),
            decoration: BoxDecoration(
              color: AppColors.purpleDim,
              borderRadius: BorderRadius.circular(20),
            ),
            child: Text(
              'LEVEL $level  •  $rank',
              style: TextStyle(
                color: AppColors.purple,
                fontSize: 11,
                fontWeight: FontWeight.w700,
                letterSpacing: 0.8,
              ),
            ),
          ),

          const SizedBox(height: 12),

          Text(
            'Welcome, Young Chemist!',
            textAlign: TextAlign.center,
            style: TextStyle(
              color: AppColors.textPrimary,
              fontSize: 22,
              fontWeight: FontWeight.w800,
              height: 1.2,
            ),
          ),

          const SizedBox(height: 8),

          Text(
            'Ready to discover how atoms dance today?\nYour periodic table journey continues!',
            textAlign: TextAlign.center,
            style: TextStyle(
              color: AppColors.textSecondary,
              fontSize: 13,
              height: 1.55,
            ),
          ),

          const SizedBox(height: 18),

          SizedBox(
            width: double.infinity,
            child: ElevatedButton(
              onPressed: () => Get.toNamed(AppRoutes.lessons),
              style: ElevatedButton.styleFrom(
                backgroundColor: AppColors.purple,
                padding: const EdgeInsets.symmetric(vertical: 16),
                shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(30)),
                elevation: 0,
              ),
              child: const Text(
                'Start Learning',
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 15,
                  fontWeight: FontWeight.w800,
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}

// ── Explore Topics ────────────────────────────────────────────────────────────

class _Topic {
  final String name;
  final IconData icon;
  final Color color;
  const _Topic(this.name, this.icon, this.color);
}

const _kTopics = [
  _Topic('Atomic Structure', Icons.hub_outlined, Color(0xFFEC4899)),
  _Topic('Chemical Bonding', Icons.device_hub_outlined, Color(0xFF16A34A)),
  _Topic('Reactions', Icons.science_outlined, Color(0xFFD97706)),
  _Topic('Stoichiometry', Icons.balance_outlined, Color(0xFF0891B2)),
];

class _ExploreTopics extends StatelessWidget {
  const _ExploreTopics();

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Row(
          children: [
            Text(
              'Explore Topics',
              style: TextStyle(
                color: AppColors.textPrimary,
                fontSize: 17,
                fontWeight: FontWeight.w800,
              ),
            ),
            const Spacer(),
            GestureDetector(
              onTap: () => Get.toNamed(AppRoutes.lessons),
              child: Text(
                'View all',
                style: TextStyle(
                  color: AppColors.purple,
                  fontSize: 13,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ),
          ],
        ),

        const SizedBox(height: 12),

        GridView.count(
          crossAxisCount: 2,
          shrinkWrap: true,
          physics: const NeverScrollableScrollPhysics(),
          crossAxisSpacing: 12,
          mainAxisSpacing: 12,
          childAspectRatio: 1.25,
          children: _kTopics.map((t) => _TopicCard(topic: t)).toList(),
        ),
      ],
    );
  }
}

class _TopicCard extends StatelessWidget {
  final _Topic topic;
  const _TopicCard({required this.topic});

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () => Get.toNamed(AppRoutes.lessons),
      child: Container(
        decoration: BoxDecoration(
          color: AppColors.bgCard,
          borderRadius: BorderRadius.circular(18),
          border: Border.all(color: topic.color.withOpacity(0.35), width: 1.5),
          boxShadow: [
            BoxShadow(
              color: topic.color.withOpacity(0.07),
              blurRadius: 12,
              offset: const Offset(0, 3),
            ),
          ],
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Container(
              width: 50,
              height: 50,
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                color: topic.color.withOpacity(0.12),
              ),
              child: Icon(topic.icon, color: topic.color, size: 24),
            ),
            const SizedBox(height: 10),
            Text(
              topic.name,
              textAlign: TextAlign.center,
              style: TextStyle(
                color: AppColors.textPrimary,
                fontSize: 13,
                fontWeight: FontWeight.w700,
              ),
            ),
          ],
        ),
      ),
    );
  }
}

// ── Daily Challenge card ──────────────────────────────────────────────────────

class _DailyChallengeCard extends StatelessWidget {
  final AppThemeVariant variant;
  const _DailyChallengeCard({required this.variant});

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () => Get.toNamed(AppRoutes.quiz),
      child: Container(
        padding: const EdgeInsets.fromLTRB(20, 18, 12, 18),
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors: [AppColors.purple, AppColors.purpleLight],
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
          ),
          borderRadius: BorderRadius.circular(22),
        ),
        child: Row(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Container(
                    padding: const EdgeInsets.symmetric(
                        horizontal: 10, vertical: 4),
                    decoration: BoxDecoration(
                      color: Colors.white.withOpacity(0.22),
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: const Text(
                      'Daily Challenge',
                      style: TextStyle(
                        color: Colors.white,
                        fontSize: 11,
                        fontWeight: FontWeight.w700,
                      ),
                    ),
                  ),
                  const SizedBox(height: 10),
                  const Text(
                    'Mystery of the\nNoble Gases',
                    style: TextStyle(
                      color: Colors.white,
                      fontSize: 19,
                      fontWeight: FontWeight.w800,
                      height: 1.25,
                    ),
                  ),
                  const SizedBox(height: 6),
                  Text(
                    "Find why Neon won't join the party!\nWin 50 bonus stars.",
                    style: TextStyle(
                      color: Colors.white.withOpacity(0.85),
                      fontSize: 12,
                      height: 1.5,
                    ),
                  ),
                  const SizedBox(height: 14),
                  Container(
                    padding: const EdgeInsets.symmetric(
                        horizontal: 16, vertical: 8),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: Text(
                      'Accept Quest',
                      style: TextStyle(
                        color: AppColors.purple,
                        fontSize: 13,
                        fontWeight: FontWeight.w800,
                      ),
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(width: 8),
            MascotBird(variant: variant, size: 90),
          ],
        ),
      ),
    );
  }
}

// ── Progress section ──────────────────────────────────────────────────────────

class _ProgressSection extends StatelessWidget {
  final double progress;
  const _ProgressSection({required this.progress});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.all(18),
      decoration: BoxDecoration(
        color: AppColors.bgCard,
        borderRadius: BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.05),
            blurRadius: 12,
            offset: const Offset(0, 3),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            'Your Progress',
            style: TextStyle(
              color: AppColors.textPrimary,
              fontSize: 16,
              fontWeight: FontWeight.w800,
            ),
          ),

          const SizedBox(height: 14),

          Row(
            children: [
              Text('Topic Mastery',
                  style: TextStyle(
                      color: AppColors.textSecondary, fontSize: 13)),
              const Spacer(),
              Text(
                '${(progress * 100).toInt()}%',
                style: TextStyle(
                  color: AppColors.textPrimary,
                  fontSize: 13,
                  fontWeight: FontWeight.w700,
                ),
              ),
            ],
          ),

          const SizedBox(height: 6),

          ClipRRect(
            borderRadius: BorderRadius.circular(6),
            child: LinearProgressIndicator(
              value: progress,
              minHeight: 8,
              backgroundColor: AppColors.purpleDim,
              color: AppColors.purple,
            ),
          ),

          const SizedBox(height: 16),

          Text('Latest Badges',
              style:
                  TextStyle(color: AppColors.textSecondary, fontSize: 13)),

          const SizedBox(height: 10),

          Row(
            children: [
              _BadgeCircle(
                  icon: Icons.emoji_events_rounded,
                  color: const Color(0xFFFBBF24),
                  locked: false),
              const SizedBox(width: 10),
              _BadgeCircle(
                  icon: Icons.flash_on_rounded,
                  color: AppColors.purple,
                  locked: false),
              const SizedBox(width: 10),
              _BadgeCircle(
                  icon: Icons.lock_rounded,
                  color: AppColors.textMuted,
                  locked: true),
            ],
          ),

          const SizedBox(height: 14),

          Center(
            child: GestureDetector(
              onTap: () {},
              child: Container(
                padding: const EdgeInsets.symmetric(
                    horizontal: 28, vertical: 10),
                decoration: BoxDecoration(
                  border:
                      Border.all(color: AppColors.purple.withOpacity(0.4)),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: Text(
                  'View Stats',
                  style: TextStyle(
                    color: AppColors.purple,
                    fontSize: 13,
                    fontWeight: FontWeight.w700,
                  ),
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class _BadgeCircle extends StatelessWidget {
  final IconData icon;
  final Color color;
  final bool locked;

  const _BadgeCircle({
    required this.icon,
    required this.color,
    required this.locked,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      width: 44,
      height: 44,
      decoration: BoxDecoration(
        shape: BoxShape.circle,
        color: locked ? AppColors.purpleDim : color.withOpacity(0.14),
        border: Border.all(
          color: locked ? AppColors.borderDefault : color.withOpacity(0.4),
          width: 1.5,
        ),
      ),
      child: Icon(icon,
          color: locked ? AppColors.textMuted : color, size: 20),
    );
  }
}
