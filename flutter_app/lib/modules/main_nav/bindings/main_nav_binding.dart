import 'package:get/get.dart';

import '../../companion/controllers/companion_controller.dart';
import '../../flashcards/controllers/flashcards_controller.dart';
import '../../pilot_profile/controllers/pilot_profile_controller.dart';
import '../controllers/main_nav_controller.dart';

class MainNavBinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut<MainNavController>(MainNavController.new);
    Get.lazyPut<CompanionController>(CompanionController.new);
    Get.lazyPut<FlashcardsController>(FlashcardsController.new);
    Get.lazyPut<PilotProfileController>(PilotProfileController.new);
  }
}
