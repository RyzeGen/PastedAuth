#pragma once
#include <iostream>
#include <Windows.h>
#include <random>
#include "xorstr.hpp"

struct ConsoleMisc
{
public:
	static void ClearNetCache()
	{
		system(XorStr("@RD /S /Q \"C:\\Users\\%username%\\AppData\\Local\\Microsoft\\Windows\\INetCache\\IE\" >nul 2>&1").c_str());
	}
	static void SetTitle(std::string title)
	{
		SetConsoleTitleA(title.c_str());
	}
	static void SetSize(int width, int height)
	{
		HWND handle = GetConsoleWindow();
		RECT rect;
		GetWindowRect(handle, &rect);
		MoveWindow(handle, rect.left, rect.top, width, height, true);
	}
};


struct RandomStrings
{
public:

	static std::string RandomString(std::string::size_type length)
	{
		static auto& chrs = "0123456789"
			"abcdefghijklmnopqrstuvwxyz"
			"ABCDEFGHIJKLMNOPQRSTUVWXYZ";

		thread_local static std::mt19937 rg{ std::random_device{}() };
		thread_local static std::uniform_int_distribution<std::string::size_type> pick(0, sizeof(chrs) - 2);

		std::string s;

		s.reserve(length);

		while (length--)
			s += chrs[pick(rg)];

		return s;
	}
};