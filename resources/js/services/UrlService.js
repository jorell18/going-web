const isProd = true;

class UrlService {
    static AppUrl() {
        if (isProd) {
            return "https://going-recommendation-system.herokuapp.com";
        } else return "https://going-web.local";
    }
}

export default UrlService;
