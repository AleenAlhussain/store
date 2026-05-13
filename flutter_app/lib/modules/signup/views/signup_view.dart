import 'package:flutter/material.dart';
import 'package:flutter_animate/flutter_animate.dart';
import 'package:get/get.dart';

import '../../../app/theme/app_colors.dart';
import '../controllers/signup_controller.dart';

class SignupView extends GetView<SignupController> {
  const SignupView({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.bgDeep,
      body: Stack(
        children: [
          Positioned.fill(
            child: DecoratedBox(
              decoration: BoxDecoration(
                gradient: RadialGradient(
                  center: const Alignment(0, -0.1),
                  radius: 0.75,
                  colors: [
                    const Color(0xFF1A2F6A).withOpacity(0.55),
                    AppColors.bgDeep,
                  ],
                ),
              ),
            ),
          ),
          SafeArea(
            child: SingleChildScrollView(
              padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 32),
              child: Column(
                children: [
                  // Back + Logo row
                  Row(
                    children: [
                      GestureDetector(
                        onTap: Get.back,
                        child: Container(
                          width: 40,
                          height: 40,
                          decoration: BoxDecoration(
                            color: AppColors.bgCard,
                            borderRadius: BorderRadius.circular(10),
                            border: Border.all(color: AppColors.borderDefault),
                          ),
                          child: Icon(Icons.arrow_back_ios_new_rounded,
                              color: AppColors.textSecondary, size: 16),
                        ),
                      ),
                      const Spacer(),
                      Container(
                        width: 44,
                        height: 44,
                        decoration: BoxDecoration(
                          color: AppColors.bgCard,
                          borderRadius: BorderRadius.circular(10),
                          border: Border.all(color: AppColors.borderDefault),
                          boxShadow: [
                            BoxShadow(
                              color: AppColors.cyan.withOpacity(0.2),
                              blurRadius: 16,
                            ),
                          ],
                        ),
                        child: const Center(
                          child: Text('⚗️', style: TextStyle(fontSize: 20)),
                        ),
                      ),
                      const Spacer(),
                      const SizedBox(width: 40),
                    ],
                  ).animate().fadeIn(duration: 400.ms),

                  const SizedBox(height: 28),

                  Text(
                    'Create Account',
                    style: Theme.of(context).textTheme.headlineMedium?.copyWith(
                          color: AppColors.textPrimary,
                          fontWeight: FontWeight.w800,
                        ),
                  ).animate().fadeIn(delay: 80.ms, duration: 400.ms),

                  const SizedBox(height: 6),

                  Text(
                    'Join the quantum research program',
                    style: TextStyle(
                        color: AppColors.textSecondary, fontSize: 14),
                  ).animate().fadeIn(delay: 160.ms, duration: 400.ms),

                  const SizedBox(height: 28),

                  // Form card
                  Container(
                    padding: const EdgeInsets.all(24),
                    decoration: BoxDecoration(
                      color: AppColors.bgCard,
                      borderRadius: BorderRadius.circular(20),
                      border: Border.all(color: AppColors.borderDefault),
                    ),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        _FieldLabel('Full Name'),
                        const SizedBox(height: 8),
                        _InputField(
                          ctrl: controller.nameController,
                          hint: 'Marie Curie',
                          icon: Icons.person_outline,
                        ),

                        const SizedBox(height: 20),

                        _FieldLabel('Institutional Email'),
                        const SizedBox(height: 8),
                        _InputField(
                          ctrl: controller.emailController,
                          hint: 'dr.curie@chem.ai',
                          icon: Icons.email_outlined,
                          keyboardType: TextInputType.emailAddress,
                        ),

                        const SizedBox(height: 20),

                        _FieldLabel('Access Key'),
                        const SizedBox(height: 8),
                        Obx(() => _InputField(
                              ctrl: controller.passwordController,
                              hint: '•••••••••••',
                              icon: Icons.lock_outline,
                              obscure: !controller.isPasswordVisible.value,
                              suffix: GestureDetector(
                                onTap: controller.togglePassword,
                                child: Padding(
                                  padding: const EdgeInsets.only(right: 12),
                                  child: Icon(
                                    controller.isPasswordVisible.value
                                        ? Icons.visibility_off_outlined
                                        : Icons.visibility_outlined,
                                    color: AppColors.textSecondary,
                                    size: 18,
                                  ),
                                ),
                              ),
                            )),

                        const SizedBox(height: 20),

                        _FieldLabel('Confirm Access Key'),
                        const SizedBox(height: 8),
                        Obx(() => _InputField(
                              ctrl: controller.confirmController,
                              hint: '•••••••••••',
                              icon: Icons.lock_outline,
                              obscure: !controller.isConfirmVisible.value,
                              suffix: GestureDetector(
                                onTap: controller.toggleConfirm,
                                child: Padding(
                                  padding: const EdgeInsets.only(right: 12),
                                  child: Icon(
                                    controller.isConfirmVisible.value
                                        ? Icons.visibility_off_outlined
                                        : Icons.visibility_outlined,
                                    color: AppColors.textSecondary,
                                    size: 18,
                                  ),
                                ),
                              ),
                            )),

                        const SizedBox(height: 28),

                        // Submit button
                        Obx(() => GestureDetector(
                              onTap: controller.isLoading.value
                                  ? null
                                  : controller.signup,
                              child: Container(
                                width: double.infinity,
                                height: 52,
                                decoration: BoxDecoration(
                                  gradient: AppColors.gradientPurple,
                                  borderRadius: BorderRadius.circular(30),
                                ),
                                alignment: Alignment.center,
                                child: controller.isLoading.value
                                    ? const SizedBox(
                                        width: 20,
                                        height: 20,
                                        child: CircularProgressIndicator(
                                          color: Colors.white,
                                          strokeWidth: 2,
                                        ),
                                      )
                                    : const Text(
                                        'Launch Account 🚀',
                                        style: TextStyle(
                                          color: Colors.white,
                                          fontSize: 15,
                                          fontWeight: FontWeight.w700,
                                        ),
                                      ),
                              ),
                            )),
                      ],
                    ),
                  )
                      .animate()
                      .fadeIn(delay: 240.ms, duration: 500.ms)
                      .slideY(begin: 0.08, duration: 500.ms, curve: Curves.easeOut),

                  const SizedBox(height: 24),

                  // Back to login
                  Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Text(
                        'Already in the lab? ',
                        style: TextStyle(
                            color: AppColors.textSecondary, fontSize: 13),
                      ),
                      GestureDetector(
                        onTap: Get.back,
                        child: Text(
                          'Log In',
                          style: TextStyle(
                            color: AppColors.purple,
                            fontSize: 13,
                            fontWeight: FontWeight.w700,
                          ),
                        ),
                      ),
                    ],
                  ).animate().fadeIn(delay: 400.ms, duration: 400.ms),

                  const SizedBox(height: 30),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class _FieldLabel extends StatelessWidget {
  final String text;
  const _FieldLabel(this.text);

  @override
  Widget build(BuildContext context) {
    return Text(
      text,
      style: TextStyle(
        color: AppColors.textSecondary,
        fontSize: 12,
        fontWeight: FontWeight.w600,
      ),
    );
  }
}

class _InputField extends StatelessWidget {
  final TextEditingController ctrl;
  final String hint;
  final IconData icon;
  final bool obscure;
  final Widget? suffix;
  final TextInputType? keyboardType;

  const _InputField({
    required this.ctrl,
    required this.hint,
    required this.icon,
    this.obscure = false,
    this.suffix,
    this.keyboardType,
  });

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: BoxDecoration(
        color: AppColors.bgCardAlt,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: AppColors.borderDefault),
      ),
      child: TextField(
        controller: ctrl,
        obscureText: obscure,
        keyboardType: keyboardType,
        style: TextStyle(color: AppColors.textPrimary, fontSize: 14),
        decoration: InputDecoration(
          hintText: hint,
          hintStyle: TextStyle(color: AppColors.textMuted, fontSize: 14),
          prefixIcon: Icon(icon, color: AppColors.textSecondary, size: 18),
          suffixIcon: suffix,
          border: InputBorder.none,
          contentPadding: const EdgeInsets.symmetric(vertical: 14),
        ),
      ),
    );
  }
}
