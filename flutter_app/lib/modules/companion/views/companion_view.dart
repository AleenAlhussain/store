import 'dart:math' as math;

import 'package:flutter/material.dart';
import 'package:flutter_animate/flutter_animate.dart';
import 'package:get/get.dart';

import '../../../app/theme/app_colors.dart';
import '../../../core/controllers/theme_controller.dart';
import '../../../widgets/mascot_bird.dart';
import '../controllers/companion_controller.dart';

class CompanionView extends GetView<CompanionController> {
  const CompanionView({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.bgBase,
      appBar: _buildAppBar(),
      body: Column(
        children: [
          Expanded(
            child: Obx(() {
              final v = Get.find<ThemeController>().variant.value;
              return ListView(
                padding: const EdgeInsets.symmetric(horizontal: 18, vertical: 12),
                children: [
                  // ── Large bird card ───────────────────────────────────
                  _BirdCard(variant: v, controller: controller)
                      .animate()
                      .fadeIn(duration: 350.ms)
                      .slideY(begin: 0.06, duration: 350.ms),

                  const SizedBox(height: 14),

                  // ── Intro speech card ─────────────────────────────────
                  _IntroCard(variant: v, controller: controller)
                      .animate()
                      .fadeIn(delay: 80.ms, duration: 350.ms)
                      .slideY(begin: 0.06, duration: 350.ms),

                  const SizedBox(height: 12),

                  // ── Topic + Level chips ───────────────────────────────
                  _TagRow()
                      .animate()
                      .fadeIn(delay: 120.ms, duration: 350.ms),

                  const SizedBox(height: 14),

                  // ── Interactive Molecule View ─────────────────────────
                  _MoleculeCard()
                      .animate()
                      .fadeIn(delay: 160.ms, duration: 350.ms),

                  const SizedBox(height: 12),

                  // ── Fun Fact ──────────────────────────────────────────
                  _InfoCard(
                    icon: Icons.lightbulb_rounded,
                    iconColor: AppColors.purple,
                    bg: AppColors.purpleDim,
                    title: 'Fun Fact!',
                    body: 'Water is the most common covalent compound on Earth!',
                  )
                      .animate()
                      .fadeIn(delay: 200.ms, duration: 350.ms),

                  const SizedBox(height: 10),

                  // ── Quick Check ───────────────────────────────────────
                  _InfoCard(
                    icon: Icons.quiz_outlined,
                    iconColor: AppColors.green,
                    bg: AppColors.greenDim,
                    title: 'Quick Check',
                    body: 'Ready for a tiny puzzle about electrons?',
                    onTap: () => controller.sendQuickReply('quiz'),
                  )
                      .animate()
                      .fadeIn(delay: 230.ms, duration: 350.ms),

                  const SizedBox(height: 14),

                  // ── Lesson Progress ───────────────────────────────────
                  _LessonProgress()
                      .animate()
                      .fadeIn(delay: 260.ms, duration: 350.ms),

                  // ── Chat messages ─────────────────────────────────────
                  if (controller.messages.isNotEmpty) ...[
                    const SizedBox(height: 16),
                    const Divider(height: 1),
                    const SizedBox(height: 10),
                    ...controller.messages.map((msg) => _ChatBubble(message: msg)),
                  ],

                  if (controller.isTyping.value) ...[
                    const SizedBox(height: 8),
                    const _TypingBubble(),
                  ],

                  const SizedBox(height: 8),
                ],
              );
            }),
          ),

          // ── Quick replies + Input ─────────────────────────────────────
          _QuickReplyBar(controller: controller),
          _InputBar(controller: controller),
        ],
      ),
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

// ── Large bird card ───────────────────────────────────────────────────────────

class _BirdCard extends StatefulWidget {
  final AppThemeVariant variant;
  final CompanionController controller;
  const _BirdCard({required this.variant, required this.controller});

  @override
  State<_BirdCard> createState() => _BirdCardState();
}

class _BirdCardState extends State<_BirdCard>
    with SingleTickerProviderStateMixin {
  late final AnimationController _ac;
  late final Animation<double> _float;

  @override
  void initState() {
    super.initState();
    _ac = AnimationController(
        vsync: this, duration: const Duration(milliseconds: 2400))
      ..repeat(reverse: true);
    _float = Tween<double>(begin: -8.0, end: 8.0).animate(
      CurvedAnimation(parent: _ac, curve: Curves.easeInOut),
    );
  }

  @override
  void dispose() {
    _ac.dispose();
    super.dispose();
  }

  Color _bgFor(AppThemeVariant v) => switch (v) {
        AppThemeVariant.quantum => const Color(0xFFEDE9FF),
        AppThemeVariant.luna    => const Color(0xFFFFF0F8),
        AppThemeVariant.milo    => const Color(0xFFF0FFF4),
        AppThemeVariant.sunny   => const Color(0xFFFFFBEB),
      };

  @override
  Widget build(BuildContext context) {
    return Container(
      height: 190,
      width: double.infinity,
      decoration: BoxDecoration(
        color: _bgFor(widget.variant),
        borderRadius: BorderRadius.circular(24),
        boxShadow: [
          BoxShadow(
            color: AppColors.purple.withOpacity(0.10),
            blurRadius: 16,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Stack(
        alignment: Alignment.center,
        children: [
          // Faint watermark initial
          Text(
            widget.controller.characterName[0],
            style: TextStyle(
              color: AppColors.purple.withOpacity(0.06),
              fontSize: 160,
              fontWeight: FontWeight.w900,
            ),
          ),
          // Floating bird
          AnimatedBuilder(
            animation: _float,
            builder: (_, child) => Transform.translate(
              offset: Offset(0, _float.value),
              child: child,
            ),
            child: Container(
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                boxShadow: [
                  BoxShadow(
                    color: AppColors.purple.withOpacity(0.18),
                    blurRadius: 24,
                    spreadRadius: 4,
                    offset: const Offset(0, 8),
                  ),
                ],
              ),
              child: MascotBird(variant: widget.variant, size: 140),
            ),
          ),
        ],
      ),
    );
  }
}

// ── Intro speech card ─────────────────────────────────────────────────────────

class _IntroCard extends StatelessWidget {
  final AppThemeVariant variant;
  final CompanionController controller;
  const _IntroCard({required this.variant, required this.controller});

  String get _lessonTopic => switch (variant) {
        AppThemeVariant.quantum => 'Quantum Orbitals',
        AppThemeVariant.luna    => 'Covalent Bonding',
        AppThemeVariant.milo    => 'Reaction Kinetics',
        AppThemeVariant.sunny   => 'The Periodic Table',
      };

  String get _lessonBody => switch (variant) {
        AppThemeVariant.quantum =>
          "Today we examine Quantum Orbitals — regions of space where electrons most likely exist. Think of them as clouds of probability around the nucleus.",
        AppThemeVariant.luna =>
          "Today we're exploring Covalent Bonding! Imagine two atoms sharing their favorite toys (electrons) so they can both be happy and stable. It's like a scientific friendship!",
        AppThemeVariant.milo =>
          "Today's challenge: Reaction Kinetics! We're figuring out WHY some reactions are faster than others. Hint: temperature and concentration are your power-ups!",
        AppThemeVariant.sunny =>
          "Today I'm going to explain The Periodic Table! Every single element has its own personality, and the table organizes them by family. It's like a map of all matter that exists!",
      };

  @override
  Widget build(BuildContext context) {
    final name = controller.characterName;

    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: AppColors.bgCard,
        borderRadius: BorderRadius.circular(18),
        border: Border.all(color: AppColors.borderDefault),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.04),
            blurRadius: 10,
            offset: const Offset(0, 2),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Text(
                'Hi there! I\'m $name ',
                style: TextStyle(
                  color: AppColors.purple,
                  fontSize: 16,
                  fontWeight: FontWeight.w800,
                ),
              ),
              Text(
                switch (variant) {
                  AppThemeVariant.luna    => '🌸',
                  AppThemeVariant.milo    => '⚡',
                  AppThemeVariant.sunny   => '☀️',
                  AppThemeVariant.quantum => '🔬',
                },
                style: const TextStyle(fontSize: 16),
              ),
            ],
          ),
          const SizedBox(height: 8),
          _buildBody(_lessonBody, _lessonTopic),
        ],
      ),
    );
  }

  Widget _buildBody(String body, String keyword) {
    final idx = body.toLowerCase().indexOf(keyword.toLowerCase());
    if (idx == -1) {
      return Text(body,
          style: TextStyle(
              color: AppColors.textPrimary, fontSize: 14, height: 1.55));
    }
    return RichText(
      text: TextSpan(
        style: TextStyle(
          color: AppColors.textPrimary,
          fontSize: 14,
          height: 1.55,
        ),
        children: [
          TextSpan(text: body.substring(0, idx)),
          TextSpan(
            text: body.substring(idx, idx + keyword.length),
            style: TextStyle(
              color: AppColors.purple,
              fontWeight: FontWeight.w700,
            ),
          ),
          TextSpan(text: body.substring(idx + keyword.length)),
        ],
      ),
    );
  }
}

// ── Tags row ──────────────────────────────────────────────────────────────────

class _TagRow extends StatelessWidget {
  const _TagRow();

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        Container(
          padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 5),
          decoration: BoxDecoration(
            color: AppColors.purpleDim,
            borderRadius: BorderRadius.circular(20),
          ),
          child: Text(
            'Atomic Structure',
            style: TextStyle(
              color: AppColors.purple,
              fontSize: 12,
              fontWeight: FontWeight.w700,
            ),
          ),
        ),
        const SizedBox(width: 8),
        Container(
          padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 5),
          decoration: BoxDecoration(
            color: AppColors.greenDim,
            borderRadius: BorderRadius.circular(20),
          ),
          child: Text(
            'Level 2',
            style: TextStyle(
              color: AppColors.green,
              fontSize: 12,
              fontWeight: FontWeight.w700,
            ),
          ),
        ),
      ],
    );
  }
}

// ── Molecule card ─────────────────────────────────────────────────────────────

class _MoleculeCard extends StatelessWidget {
  const _MoleculeCard();

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      height: 150,
      decoration: BoxDecoration(
        color: AppColors.bgCard,
        borderRadius: BorderRadius.circular(18),
        border: Border.all(color: AppColors.borderDefault),
      ),
      clipBehavior: Clip.antiAlias,
      child: Stack(
        children: [
          CustomPaint(
            size: Size.infinite,
            painter: _MoleculePainter(),
          ),
          Positioned(
            bottom: 10,
            left: 0,
            right: 0,
            child: Text(
              'Interactive Molecule View',
              textAlign: TextAlign.center,
              style: TextStyle(
                color: AppColors.textSecondary,
                fontSize: 12,
                fontWeight: FontWeight.w600,
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class _MoleculePainter extends CustomPainter {
  @override
  void paint(Canvas canvas, Size size) {
    final cx = size.width / 2;
    final cy = size.height / 2 - 10;

    final bondPaint = Paint()
      ..color = AppColors.purple.withOpacity(0.25)
      ..strokeWidth = 3
      ..style = PaintingStyle.stroke;

    final center = Offset(cx, cy);
    final atoms = [
      Offset(cx - 60, cy - 30),
      Offset(cx + 60, cy - 30),
      Offset(cx - 60, cy + 30),
      Offset(cx + 60, cy + 30),
    ];

    for (final a in atoms) {
      canvas.drawLine(center, a, bondPaint);
    }

    // Central atom (large red)
    canvas.drawCircle(center, 32,
        Paint()..color = const Color(0xFFEF4444).withOpacity(0.85));
    canvas.drawCircle(center, 32,
        Paint()
          ..color = Colors.white.withOpacity(0.15)
          ..style = PaintingStyle.stroke
          ..strokeWidth = 2);

    // Peripheral atoms (small grey)
    for (final a in atoms) {
      canvas.drawCircle(a, 14,
          Paint()..color = const Color(0xFFD1D5DB));
      canvas.drawCircle(a, 14,
          Paint()
            ..color = Colors.white.withOpacity(0.4)
            ..style = PaintingStyle.stroke
            ..strokeWidth = 1.5);
    }
  }

  @override
  bool shouldRepaint(_) => false;
}

// ── Info card (Fun Fact / Quick Check) ───────────────────────────────────────

class _InfoCard extends StatelessWidget {
  final IconData icon;
  final Color iconColor;
  final Color bg;
  final String title;
  final String body;
  final VoidCallback? onTap;

  const _InfoCard({
    required this.icon,
    required this.iconColor,
    required this.bg,
    required this.title,
    required this.body,
    this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        padding: const EdgeInsets.all(14),
        decoration: BoxDecoration(
          color: AppColors.bgCard,
          borderRadius: BorderRadius.circular(16),
          border: Border.all(color: AppColors.borderDefault),
        ),
        child: Row(
          children: [
            Container(
              width: 40,
              height: 40,
              decoration: BoxDecoration(
                color: bg,
                shape: BoxShape.circle,
              ),
              child: Icon(icon, color: iconColor, size: 20),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    title,
                    style: TextStyle(
                      color: iconColor,
                      fontSize: 13,
                      fontWeight: FontWeight.w800,
                    ),
                  ),
                  const SizedBox(height: 2),
                  Text(
                    body,
                    style: TextStyle(
                      color: AppColors.textSecondary,
                      fontSize: 12.5,
                      height: 1.4,
                    ),
                  ),
                ],
              ),
            ),
            if (onTap != null)
              Icon(Icons.chevron_right, color: AppColors.textMuted, size: 18),
          ],
        ),
      ),
    );
  }
}

// ── Lesson progress ───────────────────────────────────────────────────────────

class _LessonProgress extends StatelessWidget {
  const _LessonProgress();

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Row(
          children: [
            Text(
              'Lesson Progress',
              style: TextStyle(
                color: AppColors.textSecondary,
                fontSize: 13,
                fontWeight: FontWeight.w600,
              ),
            ),
            const Spacer(),
            Text(
              '65%',
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
            value: 0.65,
            minHeight: 8,
            backgroundColor: AppColors.purpleDim,
            color: AppColors.purple,
          ),
        ),
      ],
    );
  }
}

// ── Chat bubbles ──────────────────────────────────────────────────────────────

class _ChatBubble extends StatelessWidget {
  final CompanionMessage message;
  const _ChatBubble({required this.message});

  @override
  Widget build(BuildContext context) {
    final isUser = message.isUser;
    return Padding(
      padding: const EdgeInsets.only(bottom: 8),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.end,
        mainAxisAlignment:
            isUser ? MainAxisAlignment.end : MainAxisAlignment.start,
        children: [
          if (!isUser) ...[
            Container(
              width: 28,
              height: 28,
              decoration: BoxDecoration(
                color: AppColors.purpleDim,
                shape: BoxShape.circle,
              ),
              child: Icon(Icons.smart_toy_outlined,
                  color: AppColors.purple, size: 15),
            ),
            const SizedBox(width: 8),
          ],
          Flexible(
            child: Container(
              padding: const EdgeInsets.symmetric(horizontal: 13, vertical: 10),
              decoration: BoxDecoration(
                color: isUser ? AppColors.purple : AppColors.bgCard,
                borderRadius: BorderRadius.only(
                  topLeft: const Radius.circular(16),
                  topRight: const Radius.circular(16),
                  bottomLeft: Radius.circular(isUser ? 16 : 4),
                  bottomRight: Radius.circular(isUser ? 4 : 16),
                ),
                border: isUser
                    ? null
                    : Border.all(color: AppColors.borderDefault),
              ),
              child: Text(
                message.text,
                style: TextStyle(
                  color: isUser ? Colors.white : AppColors.textPrimary,
                  fontSize: 13,
                  height: 1.45,
                ),
              ),
            ),
          ),
          if (isUser) const SizedBox(width: 8),
        ],
      ),
    );
  }
}

class _TypingBubble extends StatelessWidget {
  const _TypingBubble();

  @override
  Widget build(BuildContext context) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.end,
      children: [
        Container(
          width: 28,
          height: 28,
          decoration: BoxDecoration(
            color: AppColors.purpleDim,
            shape: BoxShape.circle,
          ),
          child: Icon(Icons.smart_toy_outlined,
              color: AppColors.purple, size: 15),
        ),
        const SizedBox(width: 8),
        Container(
          padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 12),
          decoration: BoxDecoration(
            color: AppColors.bgCard,
            borderRadius: const BorderRadius.only(
              topLeft: Radius.circular(16),
              topRight: Radius.circular(16),
              bottomLeft: Radius.circular(4),
              bottomRight: Radius.circular(16),
            ),
            border: Border.all(color: AppColors.borderDefault),
          ),
          child: Row(
            mainAxisSize: MainAxisSize.min,
            children: List.generate(3, (i) {
              return Container(
                margin: EdgeInsets.only(right: i < 2 ? 4 : 0),
                width: 7,
                height: 7,
                decoration: BoxDecoration(
                  color: AppColors.textMuted,
                  shape: BoxShape.circle,
                ),
              )
                  .animate(onPlay: (c) => c.repeat(reverse: true))
                  .fadeIn(delay: Duration(milliseconds: i * 160), duration: 350.ms)
                  .then()
                  .fadeOut(duration: 350.ms);
            }),
          ),
        ),
      ],
    );
  }
}

// ── Quick reply chips ─────────────────────────────────────────────────────────

class _QuickReplyBar extends StatelessWidget {
  final CompanionController controller;
  const _QuickReplyBar({required this.controller});

  @override
  Widget build(BuildContext context) {
    final chips = [
      (type: 'tip', label: '🧪 Chemistry Tip'),
      (type: 'quiz', label: '🎯 Quiz Me!'),
      (type: 'fact', label: '🌟 Fun Fact'),
      (type: 'encourage', label: '💪 Encourage Me'),
    ];

    return Container(
      color: AppColors.bgBase,
      padding: const EdgeInsets.fromLTRB(12, 6, 12, 2),
      child: SingleChildScrollView(
        scrollDirection: Axis.horizontal,
        child: Row(
          children: chips.map((c) {
            return Padding(
              padding: const EdgeInsets.only(right: 8),
              child: GestureDetector(
                onTap: () => controller.sendQuickReply(c.type),
                child: Container(
                  padding: const EdgeInsets.symmetric(
                      horizontal: 13, vertical: 7),
                  decoration: BoxDecoration(
                    color: AppColors.bgCard,
                    borderRadius: BorderRadius.circular(20),
                    border: Border.all(color: AppColors.borderDefault),
                  ),
                  child: Text(
                    c.label,
                    style: TextStyle(
                      color: AppColors.textSecondary,
                      fontSize: 12,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                ),
              ),
            );
          }).toList(),
        ),
      ),
    );
  }
}

// ── Input bar ─────────────────────────────────────────────────────────────────

class _InputBar extends StatefulWidget {
  final CompanionController controller;
  const _InputBar({required this.controller});

  @override
  State<_InputBar> createState() => _InputBarState();
}

class _InputBarState extends State<_InputBar> {
  final _tc = TextEditingController();

  void _submit() {
    widget.controller.sendUserMessage(_tc.text);
    _tc.clear();
  }

  @override
  void dispose() {
    _tc.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final bottom = MediaQuery.of(context).viewInsets.bottom;
    return Padding(
      padding: EdgeInsets.fromLTRB(12, 8, 12, 12 + bottom),
      child: Row(
        children: [
          Expanded(
            child: Container(
              decoration: BoxDecoration(
                color: AppColors.bgCard,
                borderRadius: BorderRadius.circular(28),
                border: Border.all(color: AppColors.borderDefault),
              ),
              child: TextField(
                controller: _tc,
                onSubmitted: (_) => _submit(),
                style: TextStyle(
                    color: AppColors.textPrimary, fontSize: 14),
                decoration: InputDecoration(
                  hintText: 'Ask me anything about Chemistry...',
                  hintStyle: TextStyle(
                      color: AppColors.textMuted, fontSize: 13),
                  border: InputBorder.none,
                  contentPadding: const EdgeInsets.symmetric(
                      horizontal: 18, vertical: 12),
                ),
              ),
            ),
          ),
          const SizedBox(width: 8),
          GestureDetector(
            onTap: _submit,
            child: Container(
              width: 46,
              height: 46,
              decoration: BoxDecoration(
                color: AppColors.purple,
                shape: BoxShape.circle,
                boxShadow: [
                  BoxShadow(
                    color: AppColors.purple.withOpacity(0.35),
                    blurRadius: 10,
                    offset: const Offset(0, 3),
                  ),
                ],
              ),
              child: const Icon(Icons.send_rounded,
                  color: Colors.white, size: 20),
            ),
          ),
        ],
      ),
    );
  }
}
