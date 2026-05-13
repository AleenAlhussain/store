import 'package:get/get.dart';

import '../../../core/services/mentor_service.dart';
import '../../../data/models/mentor_model.dart';
import '../../../data/models/user_model.dart';
import '../../../data/repositories/chemai_repository.dart';

class HomeController extends GetxController {
  final _repo = Get.find<ChemAIRepository>();

  final user = Rxn<UserModel>();
  final isLoading = true.obs;

  MentorService get _mentorSvc => Get.find<MentorService>();
  Rxn<MentorModel> get mentor => _mentorSvc.current;
  String get greeting => _mentorSvc.greeting;

  @override
  void onReady() {
    super.onReady();
    _loadProfile();
  }

  Future<void> _loadProfile() async {
    user.value = UserModel.mock;
    isLoading.value = false;

    final result = await _repo.fetchProfile();
    if (result.data != null) user.value = result.data;
  }

  void refresh() => _loadProfile();
}
