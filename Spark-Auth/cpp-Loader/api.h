#include "http/utils.h"
#include "http/http.h"
#include "api_utils.h"
#include "base64.h"
#include "caesar.h"
#include "split.h"


class API 
{
public:
    static bool api_login(std::string username, std::string password, std::string hwid = "meme");
	static bool api_register(std::string username, std::string email, std::string password, std::string token);
	static bool api_activate(std::string spak_username, std::string token);
	static bool api_keylogin(std::string token, std::string tokenemail, std::string hwid = "meme");
	static bool api_init(std::string name, std::string version, std::string key);
	static std::string timeStampToReadble(const time_t rawTime);
	static std::string token, user, expiry;
private:
	static std::string api;
};