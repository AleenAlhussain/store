import 'package:get/get.dart';

import '../controllers/companion_controller.dart';

class CompanionBinding extends Bindings {
  @override
  void dependencies() {
    Get.lazyPut<CompanionController>(CompanionController.new);
  }
}
