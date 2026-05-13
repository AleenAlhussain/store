import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../../../app/routes/app_routes.dart';
import '../../../core/services/mentor_service.dart';

class SignupController extends GetxController {
  final nameController = TextEditingController();
  final emailController = TextEditingController();
  final passwordController = TextEditingController();
  final confirmController = TextEditingController();
  final isPasswordVisible = false.obs;
  final isConfirmVisible = false.obs;
  final isLoading = false.obs;

  @override
  void onClose() {
    nameController.dispose();
    emailController.dispose();
    passwordController.dispose();
    confirmController.dispose();
    super.onClose();
  }

  void togglePassword() => isPasswordVisible.value = !isPasswordVisible.value;
  void toggleConfirm() => isConfirmVisible.value = !isConfirmVisible.value;

  Future<void> signup() async {
    final name = nameController.text.trim();
    final email = emailController.text.trim();
    final password = passwordController.text;
    final confirm = confirmController.text;

    if (name.isEmpty || email.isEmpty || password.isEmpty || confirm.isEmpty) {
      Get.snackbar('Missing Fields', 'Please fill in all fields.',
          snackPosition: SnackPosition.BOTTOM);
      return;
    }

    if (password != confirm) {
      Get.snackbar('Password Mismatch', 'Passwords do not match.',
          snackPosition: SnackPosition.BOTTOM);
      return;
    }

    isLoading.value = true;
    await Future.delayed(const Duration(seconds: 2));

    final prefs = await SharedPreferences.getInstance();
    await prefs.setBool('logged_in', true);
    await prefs.setBool('onboarding_done', false);
    await Get.find<MentorService>().setMentor('gamer');

    isLoading.value = false;
    Get.offAllNamed(AppRoutes.onboarding);
  }
}
