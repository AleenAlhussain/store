import 'package:flutter/material.dart';

abstract final class AppColors {
  // ── Backgrounds ────────────────────────────────────────────────────────────
  static const bgDeep    = Color(0xFF080C20);  // darkest navy
  static const bgBase    = Color(0xFF0C1030);  // main scaffold
  static const bgCard    = Color(0xFF131840);  // card surface
  static const bgCardAlt = Color(0xFF1A1F4A);  // slightly lighter card

  // ── Brand accents ──────────────────────────────────────────────────────────
  static const cyan      = Color(0xFF00D4FF);
  static const cyanDim   = Color(0xFF00A8CC);
  static const purple    = Color(0xFF7C5CFC);
  static const purpleLight = Color(0xFFA688FF);
  static const purpleDim  = Color(0xFF4A3C8C);
  static const green     = Color(0xFF00E5A0);
  static const greenDim  = Color(0xFF007A55);

  // ── Text ──────────────────────────────────────────────────────────────────
  static const textPrimary   = Color(0xFFFFFFFF);
  static const textSecondary = Color(0xFF8B90B0);
  static const textMuted     = Color(0xFF4A5080);
  static const textCyan      = Color(0xFF00D4FF);

  // ── Borders / dividers ────────────────────────────────────────────────────
  static const borderDefault  = Color(0xFF2A2F60);
  static const borderSelected = Color(0xFF4E6EFF);
  static const borderGlow     = Color(0xFF00D4FF);

  // ── Status ────────────────────────────────────────────────────────────────
  static const online  = Color(0xFF00E5A0);
  static const locked  = Color(0xFF4A5080);
  static const warning = Color(0xFFFBBF24);

  // ── Gradients ─────────────────────────────────────────────────────────────
  static const gradientPurple = LinearGradient(
    colors: [Color(0xFF7C5CFC), Color(0xFF5B8BFF)],
    begin: Alignment.centerLeft,
    end: Alignment.centerRight,
  );

  static const gradientCyan = LinearGradient(
    colors: [Color(0xFF00D4FF), Color(0xFF0099CC)],
    begin: Alignment.centerLeft,
    end: Alignment.centerRight,
  );

  static const gradientCard = LinearGradient(
    colors: [Color(0xFF131840), Color(0xFF1A1F4A)],
    begin: Alignment.topLeft,
    end: Alignment.bottomRight,
  );

  static const gradientBg = RadialGradient(
    center: Alignment.center,
    radius: 1.2,
    colors: [Color(0xFF0C1030), Color(0xFF080C20)],
  );
}
