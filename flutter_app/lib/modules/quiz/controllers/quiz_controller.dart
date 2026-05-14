import 'dart:async';

import 'package:get/get.dart';

import '../../../data/models/quiz_model.dart';

class QuizController extends GetxController {
  final questions = QuizQuestion.defaults;
  final currentIndex = 0.obs;
  final selectedOption = RxnString();
  final submitted = false.obs;
  final secondsRemaining = 45.obs;
  final isCorrect = RxnBool();
  final score = 450.obs;
  Timer? _timer;

  QuizQuestion get current => questions[currentIndex.value];

  @override
  void onInit() {
    super.onInit();
    _startTimer();
  }

  void _startTimer() {
    _timer?.cancel();
    secondsRemaining.value = 45;
    _timer = Timer.periodic(const Duration(seconds: 1), (_) {
      if (secondsRemaining.value > 0) {
        secondsRemaining.value--;
      } else {
        _advance();
      }
    });
  }

  void selectOption(String letter) {
    if (submitted.value) return;
    selectedOption.value = letter;
  }

  void submitAnswer() {
    if (selectedOption.value == null || submitted.value) return;
    submitted.value = true;
    isCorrect.value = selectedOption.value == current.correctLetter;
    if (isCorrect.value == true) score.value += 50;
    Future.delayed(const Duration(milliseconds: 1800), _advance);
  }

  void _advance() {
    if (currentIndex.value < questions.length - 1) {
      currentIndex.value++;
      selectedOption.value = null;
      isCorrect.value = null;
      submitted.value = false;
      _startTimer();
    } else {
      Get.back();
    }
  }

  String get timerLabel {
    final m = secondsRemaining.value ~/ 60;
    final s = secondsRemaining.value % 60;
    return '${m.toString().padLeft(2, '0')}:${s.toString().padLeft(2, '0')}';
  }

  @override
  void onClose() {
    _timer?.cancel();
    super.onClose();
  }
}
