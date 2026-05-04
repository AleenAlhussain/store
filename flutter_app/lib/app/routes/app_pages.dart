import 'package:get/get.dart';

import '../../modules/auth/bindings/auth_binding.dart';
import '../../modules/auth/views/auth_view.dart';
import '../../modules/home/bindings/home_binding.dart';
import '../../modules/lessons/bindings/lessons_binding.dart';
import '../../modules/main_nav/bindings/main_nav_binding.dart';
import '../../modules/main_nav/views/main_nav_view.dart';
import '../../modules/mentor/bindings/mentor_binding.dart';
import '../../modules/mentor/views/mentor_view.dart';
import '../../modules/onboarding/bindings/onboarding_binding.dart';
import '../../modules/onboarding/views/onboarding_view.dart';
import '../../modules/profile/bindings/profile_binding.dart';
import '../../modules/quiz/bindings/quiz_binding.dart';
import '../../modules/quiz/views/quiz_view.dart';
import '../../modules/schedule/bindings/schedule_binding.dart';
import '../../modules/splash/bindings/splash_binding.dart';
import '../../modules/splash/views/splash_view.dart';
import 'app_routes.dart';

abstract final class AppPages {
  static final routes = <GetPage>[
    GetPage(
      name: AppRoutes.splash,
      page: () => const SplashView(),
      binding: SplashBinding(),
      transition: Transition.noTransition,
    ),
    GetPage(
      name: AppRoutes.auth,
      page: () => const AuthView(),
      binding: AuthBinding(),
      transition: Transition.fadeIn,
      transitionDuration: const Duration(milliseconds: 400),
    ),
    GetPage(
      name: AppRoutes.onboarding,
      page: () => const OnboardingView(),
      binding: OnboardingBinding(),
      transition: Transition.fadeIn,
      transitionDuration: const Duration(milliseconds: 400),
    ),
    GetPage(
      name: AppRoutes.mentor,
      page: () => const MentorView(),
      binding: MentorBinding(),
      transition: Transition.rightToLeft,
      transitionDuration: const Duration(milliseconds: 350),
    ),
    GetPage(
      name: AppRoutes.mainNav,
      page: () => const MainNavView(),
      bindings: [
        MainNavBinding(),
        HomeBinding(),
        LessonsBinding(),
        ProfileBinding(),
        ScheduleBinding(),
      ],
      transition: Transition.fadeIn,
      transitionDuration: const Duration(milliseconds: 400),
    ),
    GetPage(
      name: AppRoutes.quiz,
      page: () => const QuizView(),
      binding: QuizBinding(),
      transition: Transition.rightToLeft,
      transitionDuration: const Duration(milliseconds: 300),
    ),
  ];
}
