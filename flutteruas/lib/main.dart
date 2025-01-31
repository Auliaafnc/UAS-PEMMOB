import 'package:flutter/material.dart';
import 'package:flutteruas/pages/login_screen.dart';
import 'package:flutteruas/services/api_services.dart';
import 'package:get/get.dart'; // Tambahkan GetX
 // Import ApiService

void main() {
  Get.put(ApiService()); // Registrasikan ApiService
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return GetMaterialApp( // Gantilah MaterialApp dengan GetMaterialApp
      debugShowCheckedModeBanner: false,
      title: 'Flutter Login',
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      home: LoginScreen(),
    );
  }
}