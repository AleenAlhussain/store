import 'dart:math' as math;

import 'package:flutter/material.dart';

import '../app/theme/app_colors.dart';

class MascotBird extends StatefulWidget {
  final AppThemeVariant variant;
  final double size;
  const MascotBird({required this.variant, this.size = 100, super.key});

  @override
  State<MascotBird> createState() => _MascotBirdState();
}

class _MascotBirdState extends State<MascotBird>
    with SingleTickerProviderStateMixin {
  late final AnimationController _ac;
  late final Animation<double> _scale;

  @override
  void initState() {
    super.initState();
    _ac = AnimationController(
        vsync: this, duration: const Duration(milliseconds: 750));
    _scale = CurvedAnimation(parent: _ac, curve: Curves.elasticOut);
    _ac.forward();
  }

  @override
  void didUpdateWidget(MascotBird old) {
    super.didUpdateWidget(old);
    if (old.variant != widget.variant) {
      _ac.forward(from: 0);
    }
  }

  @override
  void dispose() {
    _ac.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return AnimatedBuilder(
      animation: _scale,
      builder: (_, child) =>
          Transform.scale(scale: _scale.value, child: child),
      child: SizedBox(
        width: widget.size,
        height: widget.size * 1.15,
        child: CustomPaint(
          painter: _BirdPainter(variant: widget.variant),
        ),
      ),
    );
  }
}

class _BirdPainter extends CustomPainter {
  final AppThemeVariant variant;

  const _BirdPainter({required this.variant});

  Color get _bodyColor => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFFEDE9FF),
        AppThemeVariant.luna    => const Color(0xFFFFB7D5),
        AppThemeVariant.milo    => const Color(0xFF86EFAC),
        AppThemeVariant.sunny   => const Color(0xFFFDE68A),
      };

  Color get _accent => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFF8B7DF8),
        AppThemeVariant.luna    => const Color(0xFFEC4899),
        AppThemeVariant.milo    => const Color(0xFF16A34A),
        AppThemeVariant.sunny   => const Color(0xFFD97706),
      };

  @override
  void paint(Canvas canvas, Size size) {
    final cx = size.width / 2;
    final cy = size.height * 0.43;
    final r = size.width * 0.44;

    _shadow(canvas, cx, cy, r);
    _body(canvas, cx, cy, r);
    _belly(canvas, cx, cy, r);
    _eyes(canvas, cx, cy, r);
    _beak(canvas, cx, cy, r);
    _feet(canvas, cx, cy, r);
    _tufts(canvas, cx, cy, r);
  }

  void _shadow(Canvas canvas, double cx, double cy, double r) {
    canvas.drawOval(
      Rect.fromCenter(
          center: Offset(cx, cy + r * 0.90), width: r * 1.5, height: r * 0.32),
      Paint()
        ..color = Colors.black.withOpacity(0.10)
        ..maskFilter = const MaskFilter.blur(BlurStyle.normal, 8),
    );
  }

  void _body(Canvas canvas, double cx, double cy, double r) {
    final hi = Color.lerp(_bodyColor, Colors.white, 0.55)!;
    final lo = Color.lerp(_bodyColor, _accent, 0.20)!;
    canvas.drawCircle(
      Offset(cx, cy),
      r,
      Paint()
        ..shader = RadialGradient(
          center: const Alignment(-0.35, -0.45),
          radius: 0.90,
          colors: [hi, _bodyColor, lo],
          stops: const [0.0, 0.5, 1.0],
        ).createShader(Rect.fromCircle(center: Offset(cx, cy), radius: r)),
    );
    canvas.drawCircle(
      Offset(cx, cy),
      r,
      Paint()
        ..color = _accent.withOpacity(0.09)
        ..style = PaintingStyle.stroke
        ..strokeWidth = r * 0.045,
    );
  }

  void _belly(Canvas canvas, double cx, double cy, double r) {
    canvas.drawOval(
      Rect.fromCenter(
          center: Offset(cx, cy + r * 0.22), width: r * 1.06, height: r * 0.86),
      Paint()..color = Color.lerp(_bodyColor, Colors.white, 0.48)!,
    );
  }

  void _eyes(Canvas canvas, double cx, double cy, double r) {
    for (final sign in [-1.0, 1.0]) {
      final ec = Offset(cx + sign * r * 0.30, cy - r * 0.04);
      final er = r * 0.215;

      // White
      canvas.drawOval(
        Rect.fromCenter(center: ec, width: er * 2.1, height: er * 2.25),
        Paint()..color = Colors.white,
      );
      canvas.drawOval(
        Rect.fromCenter(center: ec, width: er * 2.1, height: er * 2.25),
        Paint()
          ..color = Colors.black.withOpacity(0.06)
          ..style = PaintingStyle.stroke
          ..strokeWidth = 1,
      );

      // Pupil
      final pc = ec + Offset(sign * er * 0.12, er * 0.10);
      canvas.drawCircle(pc, er * 0.62, Paint()..color = const Color(0xFF1A120A));
      canvas.drawCircle(pc, er * 0.42, Paint()..color = const Color(0xFF7C5127));

      // Highlights
      canvas.drawCircle(
        pc + Offset(-sign * er * 0.20, -er * 0.26),
        er * 0.22,
        Paint()..color = Colors.white.withOpacity(0.95),
      );
      canvas.drawCircle(
        pc + Offset(sign * er * 0.12, er * 0.08),
        er * 0.11,
        Paint()..color = Colors.white.withOpacity(0.55),
      );

      // Luna eyelashes
      if (variant == AppThemeVariant.luna) {
        final lp = Paint()
          ..color = const Color(0xFF8B2252)
          ..strokeWidth = r * 0.024
          ..strokeCap = StrokeCap.round;
        for (final a in [-math.pi * 0.66, -math.pi * 0.50, -math.pi * 0.34]) {
          canvas.drawLine(
            ec + Offset(math.cos(a) * er * 1.02, math.sin(a) * er * 1.05),
            ec + Offset(math.cos(a) * er * 1.52,
                math.sin(a) * er * 1.52 - r * 0.038),
            lp,
          );
        }
      }
    }
  }

  void _beak(Canvas canvas, double cx, double cy, double r) {
    final by = cy + r * 0.17;
    final bw = r * 0.30;
    final bh = r * 0.15;
    canvas.drawRRect(
      RRect.fromRectAndRadius(
        Rect.fromCenter(center: Offset(cx, by), width: bw, height: bh),
        Radius.circular(r * 0.05),
      ),
      Paint()..color = const Color(0xFFFF9800),
    );
    canvas.drawLine(
      Offset(cx - bw * 0.38, by),
      Offset(cx + bw * 0.38, by),
      Paint()
        ..color = const Color(0xFFE65100)
        ..strokeWidth = 1.2,
    );
  }

  void _feet(Canvas canvas, double cx, double cy, double r) {
    final fy = cy + r * 0.95;
    final fp = Paint()..color = const Color(0xFFFF9800);
    for (final sign in [-1.0, 1.0]) {
      final fx = cx + sign * r * 0.25;
      canvas.drawOval(
        Rect.fromCenter(center: Offset(fx, fy), width: r * 0.30, height: r * 0.12),
        fp,
      );
      for (int i = -1; i <= 1; i++) {
        canvas.drawOval(
          Rect.fromCenter(
            center: Offset(fx + i * r * 0.10, fy + r * 0.09),
            width: r * 0.10,
            height: r * 0.15,
          ),
          fp,
        );
      }
    }
  }

  void _tufts(Canvas canvas, double cx, double cy, double r) {
    final tc = Color.lerp(_bodyColor, _accent, 0.38)!;
    final tp = Paint()..color = tc;
    final topY = cy - r * 0.84;

    switch (variant) {
      case AppThemeVariant.quantum:
        for (final ox in [-r * 0.16, 0.0, r * 0.16]) {
          canvas.drawOval(
            Rect.fromCenter(
              center: Offset(cx + ox, topY + r * 0.06),
              width: r * 0.22,
              height: r * 0.34,
            ),
            tp,
          );
        }

      case AppThemeVariant.luna:
        for (int i = 0; i < 4; i++) {
          final a = -math.pi * 0.76 + i * math.pi * 0.17;
          canvas.drawOval(
            Rect.fromCenter(
              center: Offset(cx + math.cos(a) * r * 0.18,
                  topY + r * 0.12 + math.sin(a) * r * 0.06),
              width: r * 0.20,
              height: r * 0.33,
            ),
            i.isEven
                ? tp
                : (Paint()..color = _accent.withOpacity(0.45)),
          );
        }

      case AppThemeVariant.milo:
        final sp = Paint()
          ..color = _accent.withOpacity(0.85)
          ..strokeCap = StrokeCap.round
          ..strokeWidth = r * 0.07;
        for (final ox in [-r * 0.13, 0.0, r * 0.13]) {
          canvas.drawLine(
            Offset(cx + ox, topY + r * 0.22),
            Offset(cx + ox * 0.45, topY - r * 0.04),
            sp,
          );
        }

      case AppThemeVariant.sunny:
        canvas.drawOval(
          Rect.fromCenter(
            center: Offset(cx, topY + r * 0.10),
            width: r * 0.24,
            height: r * 0.38,
          ),
          Paint()..color = _accent.withOpacity(0.72),
        );
    }
  }

  @override
  bool shouldRepaint(_BirdPainter o) => o.variant != variant;
}
