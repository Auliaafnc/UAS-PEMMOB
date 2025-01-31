import 'dart:convert';

import 'package:flutteruas/models/product.dart';
import 'package:http/http.dart' as http;

class ApiService {
  static const String baseUrl = "http://localhost:83/api";
  String? _authToken; // Token autentikasi

  // Simpan token setelah login
  void setAuthToken(String token) {
    _authToken = token;
  }

  // Helper function to set headers with Authorization
  Map<String, String> _getHeaders() {
    if (_authToken == null) {
      throw Exception("Authentication token is not set.");
    }

    return {
      'Authorization': 'Bearer $_authToken',
      'Accept': 'application/json',
      'Content-Type': 'application/json',
    };
  }

  // Login method
  Future<String> login(String email, String password) async {
    final url = Uri.parse("$baseUrl/login");

    final response = await http.post(
      url,
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: {
        'email': email,
        'password': password,
      },
    );

    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      if (data['token'] != null) {
        setAuthToken(data['token']); // Simpan token
        return data['token'];
      } else {
        throw Exception("Token not found in response.");
      }
    } else if (response.statusCode == 403) {
      throw Exception("You are not authorized to login.");
    } else if (response.statusCode == 401) {
      throw Exception("Incorrect email or password.");
    } else {
      throw Exception("Login failed: ${response.body}");
    }
  }

   Future<List<Product>> fetchProducts() async {
  final url = Uri.parse("$baseUrl/products");
  final response = await http.get(url, headers: _getHeaders());

  print("Response status: ${response.statusCode}");
  print("Response body: ${response.body}"); // Debugging response body

  if (response.statusCode == 200) {
    final jsonResponse = json.decode(response.body);

    // Mengambil array produk dari jsonResponse['data']
    final List<dynamic> productsData = jsonResponse['data'];
    
    // Memastikan data produk valid
    if (productsData is List) {
      return productsData.map((json) {
        // Konversi harga dari String ke double
        json['price'] = double.tryParse(json['price'].toString()) ?? 0.0;
        return Product.fromJson(json);
      }).toList();
    } else {
      throw Exception("Data produk tidak ditemukan.");
    }
  } else {
    throw Exception("Gagal memuat produk: ${response.body}");
  }
}


}