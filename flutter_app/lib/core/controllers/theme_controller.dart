import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../../app/theme/app_colors.dart';

class ThemeController extends GetxController {
  final variant = AppThemeVariant.quantum.obs;

  bool get isDark => variant.value == AppThemeVariant.quantum;

  String get label => switch (variant.value) {
        AppThemeVariant.quantum => 'QUANTUM',
        AppThemeVariant.luna    => 'LUNA',
        AppThemeVariant.milo    => 'MILO',
        AppThemeVariant.sunny   => 'SUNNY',
      };

  @override
  void onInit() {
    super.onInit();
    _load();
  }

  void setVariant(AppThemeVariant v) {
    variant.value = v;
    AppColors.variant = v;
    Get.changeThemeMode(
        v == AppThemeVariant.quantum ? ThemeMode.dark : ThemeMode.light);
    _save(v);
  }

  Future<void> _load() async {
    final prefs = await SharedPreferences.getInstance();
    final name = prefs.getString('theme_variant') ?? 'quantum';
    final v = AppThemeVariant.values.firstWhere(
      (e) => e.name == name,
      orElse: () => AppThemeVariant.quantum,
    );
    variant.value = v;
    AppColors.variant = v;
    Get.changeThemeMode(
        v == AppThemeVariant.quantum ? ThemeMode.dark : ThemeMode.light);
  }

  Future<void> _save(AppThemeVariant v) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('theme_variant', v.name);
  }
}
