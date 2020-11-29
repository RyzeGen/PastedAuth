#include "api.h"
#include <time.h>
#include "xorstr.hpp"
#pragma warning(disable:4996)

std::string API::api = "http://localhost/Spark-Auth/api/";
std::string API::token = "";
std::string API::user = "";
std::string API::expiry = "";

bool API::api_init(std::string name, std::string version, std::string key) {
	http::post_data values = {
		{"name", base64_encode(aesar::encipher(base64_encode(name), 8))},
		{"version", base64_encode(aesar::encipher(base64_encode(version), 8))},
		{"key", base64_encode(aesar::encipher(base64_encode(key), 8))}
	};
	std::string result = base64_decode(aesar::decipher(base64_decode(http::post(api + "spark_handler.php?init", values)->text), 8));

	if (result == "")
	{
		MessageBox(0, L"empty_response", L"", MB_OK);
		return false;
	}
	else if (result == "no_client")
	{
		MessageBox(0, L"no_client", L"", MB_OK);
		return false;
	}
	else if (result == "invaild_key")
	{
		MessageBox(0, L"invaild_key", L"", MB_OK);
		return false;
	}
	else if (result == "invaild_version")
	{
		MessageBox(0, L"invaild_version", L"", MB_OK);
		return false;
	}
	else if (result == "loader_disabled")
	{
		MessageBox(0, L"loader_disabled", L"", MB_OK);
		return false;
	}
	else if (result == "success")
	{
		return true;
	}
	else {
		MessageBox(0, L"unknown_response", L"", MB_OK);
		return false;
	}
}

bool API::api_login(std::string username, std::string password, std::string hwid) {
	if (hwid == "meme") hwid = ReqUtils::serial();
	
	http::post_data values = {
		{"username", base64_encode(aesar::encipher(base64_encode(username), 8))},
		{"password", base64_encode(aesar::encipher(base64_encode(password), 8))},
		{"hwid", base64_encode(aesar::encipher(base64_encode(hwid), 8))}
	};

	std::string result = base64_decode(aesar::decipher(base64_decode(http::post(api + "spark_handler.php?login", values)->text), 8));

	if (result == "") 
	{
		MessageBox(0, L"empty_response", L"", MB_OK);
		return false;
	}
	else if (result == "empty_username")
	{
		MessageBox(0, L"empty_username", L"", MB_OK);
		return false;
	}
	else if (result == "invalid_username")
	{
		MessageBox(0, L"invalid_username", L"", MB_OK);
		return false;
	}
	else if (result == "empty_password")
	{
		MessageBox(0, L"empty_password", L"", MB_OK);
		return false;
	}
	else if (result == "wrong_password")
	{
		MessageBox(0, L"wrong_password", L"", MB_OK);
		return false;
	}
	else if (result == "no_sub")
	{
		MessageBox(0, L"no_sub", L"", MB_OK);
		return false;
	}
	else if (result == "wrong_hwid")
	{
		MessageBox(0, L"wrong_hwid", L"", MB_OK);
		return false;
	}
	else if(result.find("logged_in") != std::string::npos)
	{
		printf_s(XorStr("\n  Logged in!\n").c_str());
		Sleep(750);
		system(XorStr("cls").c_str());
		std::vector<std::string> x_x = x_spliter::split(result, '|');
		token = x_x[1];
		user = x_x[2];
		expiry = x_x[3];
		return true;
	}
	else {
		MessageBox(0, L"unknown_response", L"", MB_OK);
		return false;
	}
}
 
std::string API::timeStampToReadble(const time_t timestamp) {
	const time_t rawtime = (const time_t)timestamp;

	struct tm* dt;
	char timestr[30];
	char buffer[30];

	dt = localtime(&rawtime);
	strftime(timestr, sizeof(timestr), " %H:%M:%S %d/%m/%Y", dt);
	sprintf(buffer, "%s", timestr);
	std::string stdBuffer(buffer);
	return stdBuffer;
}

bool API::api_activate(std::string username, std::string token) {

	http::post_data values = {
		{"username", base64_encode(aesar::encipher(base64_encode(username), 8))},
		{"token", base64_encode(aesar::encipher(base64_encode(token), 8))}
	};

	std::string result = base64_decode(aesar::decipher(base64_decode(http::post(api + "spark_handler.php?activate", values)->text), 8));
	if (result == "")
	{
		MessageBox(0, L"empty_response", L"", MB_OK);
		return false;
	}
	else if (result == "unexistent_user")
	{
		MessageBox(0, L"unexistent_user", L"", MB_OK);
		return false;
	}
	else if (result == "unexistent_key")
	{
		MessageBox(0, L"unexistent_key", L"", MB_OK);
		return false;
	}
	else if (result == "already_used_key")
	{
		MessageBox(0, L"already_used_key", L"", MB_OK);
		return false;
	}
	else if (result == "success")
	{
		MessageBox(0, L"success_activated", L"", MB_OK);
		return false;
	}
	else {
		MessageBox(0, L"unknown_response", L"", MB_OK);
		return false;
	}
}


bool API::api_keylogin(std::string token, std::string tokenemail, std::string hwid)
{
	if (hwid == "meme") hwid = ReqUtils::serial();
	http::post_data values = {
		{"token", base64_encode(aesar::encipher(base64_encode(token), 8))},
		{"tokenemail", base64_encode(aesar::encipher(base64_encode(tokenemail), 8))},
		{"hwid", base64_encode(aesar::encipher(base64_encode(hwid), 8))}
	};

	std::string result = base64_decode(aesar::decipher(base64_decode(http::post(api + "spark_handler.php?keylogin", values)->text), 8));

	if (result == "")
	{
		MessageBox(0, L"empty_response", L"", MB_OK);
		return false;
	}
	else if (result == "username_already_taken")
	{
		MessageBox(0, L"username_already_taken", L"", MB_OK);
		return false;
	}
	else if (result == "invalid_email")
	{
		MessageBox(0, L"invalid_email", L"", MB_OK);
		return false;
	}
	else if (result == "email_already_taken")
	{
		MessageBox(0, L"email_already_taken", L"", MB_OK);
		return false;
	}
	else if (result == "unexistent_key")
	{
		MessageBox(0, L"unexistent_key", L"", MB_OK);
		return false;
	}
	else if (result == "already_used_key")
	{
		MessageBox(0, L"already_used_key", L"", MB_OK);
		return false;
	}
	else if (result == "error_creating_user")
	{
		MessageBox(0, L"error_creating_user", L"", MB_OK);
		return false;
	}
	else if (result == "invalid_username")
	{
		MessageBox(0, L"invalid_username", L"", MB_OK);
		return false;
	}
	else if (result == "empty_password")
	{
		MessageBox(0, L"empty_password", L"", MB_OK);
		return false;
	}
	else if (result == "wrong_password")
	{
		MessageBox(0, L"wrong_password", L"", MB_OK);
		return false;
	}
	else if (result == "no_sub")
	{
		MessageBox(0, L"no_sub", L"", MB_OK);
		return false;
	}
	else if (result == "wrong_hwid")
	{
		MessageBox(0, L"wrong_hwid", L"", MB_OK);
		return false;
	}
	else if (result.find("logged_in") != std::string::npos)
	{
		std::vector<std::string> x_x = x_spliter::split(result, '|');
		user = x_x[1];
		expiry = x_x[2];
		return true;
	}
	else if (result == "empty_data")
	{
		MessageBox(0, L"empty_data", L"", MB_OK);
		return false;
	}
	else {
		MessageBox(0, L"unknown_response", L"", MB_OK);
		return false;
	}
}

bool API::api_register(std::string username, std::string email, std::string password, std::string token)
{

	http::post_data values = {
		{"username", base64_encode(aesar::encipher(base64_encode(username), 8))},
		{"email", base64_encode(aesar::encipher(base64_encode(email), 8))},
		{"password", base64_encode(aesar::encipher(base64_encode(password), 8))},
		{"token", base64_encode(aesar::encipher(base64_encode(token), 8))}
	};

	std::string result = base64_decode(aesar::decipher(base64_decode(http::post(api + "spark_handler.php?register", values)->text), 8));

	if (result == "")
	{
		MessageBox(0, L"empty_response", L"", MB_OK);
		return false;
	}
	else if (result == "username_already_taken")
	{
		MessageBox(0, L"username_already_taken", L"", MB_OK);
		return false;
	}
	else if (result == "invalid_email")
	{
		MessageBox(0, L"invalid_email", L"", MB_OK);
		return false;
	}
	else if (result == "email_already_taken")
	{
		MessageBox(0, L"email_already_taken", L"", MB_OK);
		return false;
	}
	else if (result == "unexistent_key")
	{
		MessageBox(0, L"unexistent_key", L"", MB_OK);
		return false;
	}
	else if (result == "already_used_key")
	{
		MessageBox(0, L"already_used_key", L"", MB_OK);
		return false;
	}
	else if (result == "error_creating_user")
	{
		MessageBox(0, L"error_creating_user", L"", MB_OK);
		return false;
	}
	else if (result == "success")
	{
		MessageBox(0, L"success_registerd", L"", MB_OK);
		return false;
	}
	else if (result == "empty_data")
	{
		MessageBox(0, L"empty_data", L"", MB_OK);
		return false;
	}
	else {
		MessageBox(0, L"unknown_response", L"", MB_OK);
		return false;
	}
}