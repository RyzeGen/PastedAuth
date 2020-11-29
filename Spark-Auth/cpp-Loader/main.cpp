#include "api.h"
#include "protection.h"
#include <iostream>
#include <fstream>
#include "xorstr.hpp"
#include <Psapi.h>
#include "others.h"
#include <thread>

HANDLE color;

HWND hwnd = NULL;
std::string username;
std::string password;
std::string token;
std::string Expiry;
std::string StatusFromSite;

#define NAME				XorStr("UnrealCheats-Fortnite").c_str()
#define VERSION				XorStr("1.0.0").c_str()
#define KEY					XorStr("kp9QLZDAYDF1bQ99lscV").c_str()

void protection() {
	Windows();
	EnumWindows(WorkerProc, NULL);
	DebuggerPresent();
	outputDebugString();
}

void start() {
	while (true) {
		protection();
		std::this_thread::sleep_for(std::chrono::seconds(3));
	}
}

int main()
{
	ConsoleMisc::ClearNetCache();
	color = GetStdHandle(STD_OUTPUT_HANDLE);
	SetConsoleTextAttribute(color, 11);
	printf_s(XorStr("\n\n  Initializing..\n").c_str());
	ConsoleMisc::SetTitle(RandomStrings::RandomString(30));
	Sleep(750);
	std::thread th(start);
	if (API::api_init(NAME, VERSION, KEY)) {
		system(XorStr("cls").c_str());
		SetConsoleTextAttribute(color, 11);
		printf_s(XorStr("  Initialized!\n").c_str());
		Sleep(750);
		system(XorStr("cls").c_str());
		printf_s(XorStr("\n  Connecting..\n").c_str());
		Sleep(750);
		system(XorStr("cls").c_str());
		ConsoleMisc::ClearNetCache();
		printf_s(XorStr("  Connected!\n").c_str());
		Sleep(750);
		system(XorStr("cls").c_str());
		int option = 0;
		std::cout << "\n\n";
		std::cout << " [1] Login\n";
		std::cout << " [2] Register\n";
		std::cout << " [3] Activate\n";
		std::cout << " [4] Key Login\n";
		std::cout << "\n";
		std::cout << " [-] Option: ";
		std::cin >> option;
		if (option == 1) {
			system("cls");
			std::cout << "\n\n";
			std::cout << " Username: ";
			std::cin >> username;
			std::cout << "\n Password: ";
			std::cin >> password;

			if (API::api_login(username, password)) {
				system("cls");
				std::cout << "\n";
				std::cout << " " + API::user + "\n";
				std::cout << " " + API::expiry + "\n";
				system("pause");
			}
		}
		else if (option == 2) {
			system("cls");

			std::cout << "username : ";
			std::cin >> username;
			std::cout << "password : ";
			std::cin >> password;
			std::cout << "token: ";
			std::cin >> token;

			if (API::api_register(username, username + "@gmail.com", password, token)) {
				MessageBox(0, L"success", L"", MB_OK);
			}
		}
		else if (option == 3) {
			system("cls");

			std::cout << "Username To Extend Expire Date: ";
			std::cin >> username;
			std::cout << "New Token: ";
			std::cin >> token;

			if (API::api_activate(username, token)) {
				MessageBox(0, L"success", L"", MB_OK);
			}
		}
		else if (option == 4) {
			system("cls");

			std::cout << "token: ";
			std::cin >> token;

			if (API::api_keylogin(token, token + "@gmail.com")) {
				MessageBox(0, L"success", L"", MB_OK);
				system("cls");
				std::cout << API::token + "\n";
				std::cout << API::user + "\n";
				std::cout << API::expiry + "\n";
				system("pause");
			}
		}
	}
	else {
		std::exit(0);
	}
}