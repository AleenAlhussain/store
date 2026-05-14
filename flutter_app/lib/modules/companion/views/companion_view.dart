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
      appBar: _buildAppBar(context),
      body: Column(
        children: [
          _MascotHeader(controller: controller),
          const Divider(height: 1, color: AppColors.borderDefault),
          Expanded(child: _MessageList(controller: controller)),
          _QuickReplies(controller: controller),
          _InputBar(controller: controller),
        ],
      ),
    );
  }

  PreferredSizeWidget _buildAppBar(BuildContext context) {
    return AppBar(
      backgroundColor: AppColors.bgBase,
      automaticallyImplyLeading: false,
      titleSpacing: 18,
      title: Obx(() {
        final v = Get.find<ThemeController>().variant.value;
        return Text(
          controller.characterName.toUpperCase(),
          style: const TextStyle(
            color: AppColors.textPrimary,
            fontSize: 14,
            fontWeight: FontWeight.w800,
            letterSpacing: 2.0,
          ),
        );
      }),
      actions: [
        Container(
          margin: const EdgeInsets.only(right: 16),
          padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
          decoration: BoxDecoration(
            color: AppColors.purpleDim,
            borderRadius: BorderRadius.circular(20),
          ),
          child: Row(
            mainAxisSize: MainAxisSize.min,
            children: [
              Container(
                width: 6,
                height: 6,
                decoration: const BoxDecoration(
                  color: AppColors.online,
                  shape: BoxShape.circle,
                ),
              ),
              const SizedBox(width: 5),
              Text(
                'COMPANION',
                style: TextStyle(
                  color: AppColors.purple,
                  fontSize: 9,
                  fontWeight: FontWeight.w700,
                  letterSpacing: 1.2,
                ),
              ),
            ],
          ),
        ),
      ],
    );
  }
}

// ── Floating mascot header ────────────────────────────────────────────────────

class _MascotHeader extends StatelessWidget {
  final CompanionController controller;
  const _MascotHeader({required this.controller});

  @override
  Widget build(BuildContext context) {
    return Obx(() {
      final v = Get.find<ThemeController>().variant.value;
      final bodyColor = switch (v) {
        AppThemeVariant.quantum => const Color(0xFFEDE9FF),
        AppThemeVariant.luna    => const Color(0xFFFFB7D5),
        AppThemeVariant.milo    => const Color(0xFF86EFAC),
        AppThemeVariant.sunny   => const Color(0xFFFDE68A),
      };

      return Container(
        width: double.infinity,
        padding: const EdgeInsets.fromLTRB(20, 16, 20, 20),
        decoration: BoxDecoration(
          gradient: LinearGradient(
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            colors: [
              bodyColor.withOpacity(0.18),
              AppColors.bgBase.withOpacity(0.0),
            ],
          ),
        ),
        child: Row(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            _FloatingBird(variant: v),
            const SizedBox(width: 16),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(
                    children: [
                      Text(
                        controller.characterName,
                        style: TextStyle(
                          color: AppColors.purple,
                          fontSize: 20,
                          fontWeight: FontWeight.w800,
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
                  const SizedBox(height: 4),
                  Text(
                    controller.characterMood,
                    style: const TextStyle(
                      color: AppColors.textSecondary,
                      fontSize: 12,
                      height: 1.4,
                    ),
                  ),
                  const SizedBox(height: 10),
                  _QuickStatRow(),
                ],
              ),
            ),
          ],
        ),
      );
    });
  }
}

class _FloatingBird extends StatefulWidget {
  final AppThemeVariant variant;
  const _FloatingBird({required this.variant});

  @override
  State<_FloatingBird> createState() => _FloatingBirdState();
}

class _FloatingBirdState extends State<_FloatingBird>
    with SingleTickerProviderStateMixin {
  late final AnimationController _ac;
  late final Animation<double> _float;

  @override
  void initState() {
    super.initState();
    _ac = AnimationController(
        vsync: this, duration: const Duration(milliseconds: 2200))
      ..repeat(reverse: true);
    _float = Tween<double>(begin: -6.0, end: 6.0).animate(
      CurvedAnimation(parent: _ac, curve: Curves.easeInOut),
    );
  }

  @override
  void dispose() {
    _ac.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return AnimatedBuilder(
      animation: _float,
      builder: (_, child) =>
          Transform.translate(offset: Offset(0, _float.value), child: child),
      child: MascotBird(variant: widget.variant, size: 100),
    );
  }
}

class _QuickStatRow extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        _StatChip(icon: Icons.local_fire_department_rounded,
            label: '7-day streak', color: const Color(0xFFFF6B35)),
        const SizedBox(width: 8),
        _StatChip(icon: Icons.star_rounded,
            label: '1,240 XP', color: const Color(0xFFFBBF24)),
      ],
    );
  }
}

class _StatChip extends StatelessWidget {
  final IconData icon;
  final String label;
  final Color color;
  const _StatChip({required this.icon, required this.label, required this.color});

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
      decoration: BoxDecoration(
        color: color.withOpacity(0.12),
        borderRadius: BorderRadius.circular(10),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(icon, color: color, size: 13),
          const SizedBox(width: 4),
          Text(
            label,
            style: TextStyle(
              color: color,
              fontSize: 10,
              fontWeight: FontWeight.w700,
            ),
          ),
        ],
      ),
    );
  }
}

// ── Message list ──────────────────────────────────────────────────────────────

class _MessageList extends StatefulWidget {
  final CompanionController controller;
  const _MessageList({required this.controller});

  @override
  State<_MessageList> createState() => _MessageListState();
}

class _MessageListState extends State<_MessageList> {
  final _scroll = ScrollController();

  @override
  void dispose() {
    _scroll.dispose();
    super.dispose();
  }

  void _scrollToBottom() {
    WidgetsBinding.instance.addPostFrameCallback((_) {
      if (_scroll.hasClients) {
        _scroll.animateTo(
          _scroll.position.maxScrollExtent,
          duration: const Duration(milliseconds: 320),
          curve: Curves.easeOut,
        );
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return Obx(() {
      final msgs = widget.controller.messages;
      final typing = widget.controller.isTyping.value;
      _scrollToBottom();

      return ListView.builder(
        controller: _scroll,
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
        itemCount: msgs.length + (typing ? 1 : 0),
        itemBuilder: (_, i) {
          if (typing && i == msgs.length) {
            return const _TypingBubble()
                .animate()
                .fadeIn(duration: 200.ms);
          }
          final msg = msgs[i];
          return _ChatBubble(message: msg)
              .animate()
              .fadeIn(duration: 250.ms)
              .slideY(begin: 0.1, duration: 250.ms, curve: Curves.easeOut);
        },
      );
    });
  }
}

class _ChatBubble extends StatelessWidget {
  final CompanionMessage message;
  const _ChatBubble({required this.message});

  @override
  Widget build(BuildContext context) {
    final isUser = message.isUser;
    return Padding(
      padding: const EdgeInsets.only(bottom: 10),
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
                  color: AppColors.purple, size: 16),
            ),
            const SizedBox(width: 8),
          ],
          Flexible(
            child: Container(
              padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 10),
              decoration: BoxDecoration(
                color: isUser ? AppColors.purple : AppColors.bgCard,
                borderRadius: BorderRadius.only(
                  topLeft: const Radius.circular(16),
                  topRight: const Radius.circular(16),
                  bottomLeft:
                      Radius.circular(isUser ? 16 : 4),
                  bottomRight:
                      Radius.circular(isUser ? 4 : 16),
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
                  height: 1.5,
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
    return Padding(
      padding: const EdgeInsets.only(bottom: 10),
      child: Row(
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
                color: AppColors.purple, size: 16),
          ),
          const SizedBox(width: 8),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
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
                  child: _Dot(delay: Duration(milliseconds: i * 160)),
                );
              }),
            ),
          ),
        ],
      ),
    );
  }
}

class _Dot extends StatelessWidget {
  final Duration delay;
  const _Dot({required this.delay});

  @override
  Widget build(BuildContext context) {
    return Container(
      width: 7,
      height: 7,
      decoration: BoxDecoration(
        color: AppColors.textMuted,
        shape: BoxShape.circle,
      ),
    )
        .animate(onPlay: (c) => c.repeat(reverse: true))
        .fadeIn(delay: delay, duration: 350.ms)
        .then()
        .fadeOut(duration: 350.ms);
  }
}

// ── Quick replies ─────────────────────────────────────────────────────────────

class _QuickReplies extends StatelessWidget {
  final CompanionController controller;
  const _QuickReplies({required this.controller});

  static const _chips = [
    (type: 'tip',       label: '🧪  Chemistry Tip'),
    (type: 'quiz',      label: '🎯  Quiz Me!'),
    (type: 'fact',      label: '🌟  Fun Fact'),
    (type: 'encourage', label: '💪  Encourage Me'),
  ];

  @override
  Widget build(BuildContext context) {
    return Container(
      color: AppColors.bgBase,
      padding: const EdgeInsets.fromLTRB(12, 8, 12, 4),
      child: SingleChildScrollView(
        scrollDirection: Axis.horizontal,
        child: Row(
          children: _chips.map((c) {
            return Padding(
              padding: const EdgeInsets.only(right: 8),
              child: GestureDetector(
                onTap: () => controller.sendQuickReply(c.type),
                child: Container(
                  padding: const EdgeInsets.symmetric(
                      horizontal: 14, vertical: 8),
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
                borderRadius: BorderRadius.circular(24),
                border: Border.all(color: AppColors.borderDefault),
              ),
              child: TextField(
                controller: _tc,
                onSubmitted: (_) => _submit(),
                style: const TextStyle(
                    color: AppColors.textPrimary, fontSize: 14),
                decoration: InputDecoration(
                  hintText: 'Message your companion...',
                  hintStyle: const TextStyle(
                      color: AppColors.textMuted, fontSize: 14),
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
