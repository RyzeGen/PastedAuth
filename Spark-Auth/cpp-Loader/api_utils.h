#include <windows.h>

class api_utils {
public:
	static std::string wstring_to_string(const std::wstring& ws) {
		const std::string s(ws.begin(), ws.end());
		return s;
	}
	static std::wstring string_to_wstring(const std::string& s) {
		const std::wstring ws(s.begin(), s.end());
		return ws;
	}
};