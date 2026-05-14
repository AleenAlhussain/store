import 'package:flutter/material.dart';

enum AppThemeVariant { quantum, luna, milo, sunny }

// All properties are static getters backed by `variant`.
// Set `AppColors.variant` before triggering a rebuild to switch palettes.
abstract final class AppColors {
  static AppThemeVariant variant = AppThemeVariant.quantum;
  static bool get isDark => variant == AppThemeVariant.quantum;

  // ── Semantic constants (theme-invariant) ───────────────────────────────────
  static const amber   = Color(0xFFFBBF24);
  static const danger  = Color(0xFFEF4444);
  static const warning = Color(0xFFFBBF24);

  // ── Backgrounds ────────────────────────────────────────────────────────────
  static Color get bgDeep => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFF070A1C),
        AppThemeVariant.luna    => const Color(0xFFFFF0F8),
        AppThemeVariant.milo    => const Color(0xFFF0FFF4),
        AppThemeVariant.sunny   => const Color(0xFFFFFBEB),
      };

  static Color get bgBase => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFF0C0F2A),
        AppThemeVariant.luna    => const Color(0xFFFFF5FA),
        AppThemeVariant.milo    => const Color(0xFFF5FFF7),
        AppThemeVariant.sunny   => const Color(0xFFFFFDF0),
      };

  static Color get bgCard => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFF121638),
        _                       => const Color(0xFFFFFFFF),
      };

  static Color get bgCardAlt => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFF181D48),
        AppThemeVariant.luna    => const Color(0xFFFFF0F5),
        AppThemeVariant.milo    => const Color(0xFFDCFCE7),
        AppThemeVariant.sunny   => const Color(0xFFFEF9C3),
      };

  // ── Brand accents ──────────────────────────────────────────────────────────
  static Color get purple => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFF8B7DF8),
        AppThemeVariant.luna    => const Color(0xFFEC4899),
        AppThemeVariant.milo    => const Color(0xFF16A34A),
        AppThemeVariant.sunny   => const Color(0xFFD97706),
      };

  static Color get purpleLight => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFFB5A8FF),
        AppThemeVariant.luna    => const Color(0xFFF9A8D4),
        AppThemeVariant.milo    => const Color(0xFF86EFAC),
        AppThemeVariant.sunny   => const Color(0xFFFCD34D),
      };

  static Color get purpleDim => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFF3D3280),
        AppThemeVariant.luna    => const Color(0xFFFCE7F3),
        AppThemeVariant.milo    => const Color(0xFFDCFCE7),
        AppThemeVariant.sunny   => const Color(0xFFFEF3C7),
      };

  static Color get cyan => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFF22D3EE),
        AppThemeVariant.luna    => const Color(0xFF0891B2),
        AppThemeVariant.milo    => const Color(0xFF06B6D4),
        AppThemeVariant.sunny   => const Color(0xFF0891B2),
      };

  static Color get cyanDim => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFF0891B2),
        _                       => const Color(0xFFBAE6FD),
      };

  static Color get green => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFF34D399),
        AppThemeVariant.milo    => const Color(0xFF22C55E),
        _                       => const Color(0xFF10B981),
      };

  static Color get greenDim => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFF065F46),
        _                       => const Color(0xFFD1FAE5),
      };

  // ── Text ──────────────────────────────────────────────────────────────────
  static Color get textPrimary => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFFF0F2FF),
        AppThemeVariant.luna    => const Color(0xFF1A0810),
        AppThemeVariant.milo    => const Color(0xFF052E16),
        AppThemeVariant.sunny   => const Color(0xFF1C1200),
      };

  static Color get textSecondary => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFF8B92B8),
        AppThemeVariant.luna    => const Color(0xFF9D5B7B),
        AppThemeVariant.milo    => const Color(0xFF4D7A5A),
        AppThemeVariant.sunny   => const Color(0xFF92400E),
      };

  static Color get textMuted => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFF464D7A),
        AppThemeVariant.luna    => const Color(0xFFD4A0B8),
        AppThemeVariant.milo    => const Color(0xFF6EBF8A),
        AppThemeVariant.sunny   => const Color(0xFFCA8A04),
      };

  static Color get textCyan => cyan;

  // ── Borders ───────────────────────────────────────────────────────────────
  static Color get borderDefault => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFF1E2458),
        AppThemeVariant.luna    => const Color(0xFFFBCFE8),
        AppThemeVariant.milo    => const Color(0xFFBBF7D0),
        AppThemeVariant.sunny   => const Color(0xFFFDE68A),
      };

  static Color get borderSelected => purple;
  static Color get borderGlow     => cyan;

  // ── Status ────────────────────────────────────────────────────────────────
  static Color get online => green;
  static Color get locked => switch (variant) {
        AppThemeVariant.quantum => const Color(0xFF464D7A),
        _                       => const Color(0xFF94A3B8),
      };

  // ── Gradients ─────────────────────────────────────────────────────────────
  static LinearGradient get gradientPurple => LinearGradient(
        colors: [purple, purpleLight],
        begin: Alignment.centerLeft,
        end: Alignment.centerRight,
      );

  static LinearGradient get gradientCyan => LinearGradient(
        colors: [cyan, cyanDim],
        begin: Alignment.centerLeft,
        end: Alignment.centerRight,
      );

  static LinearGradient get gradientCard => LinearGradient(
        colors: [bgCard, bgCardAlt],
        begin: Alignment.topLeft,
        end: Alignment.bottomRight,
      );

  static RadialGradient get gradientBg => RadialGradient(
        center: Alignment.center,
        radius: 1.2,
        colors: [bgBase, bgDeep],
      );
}
