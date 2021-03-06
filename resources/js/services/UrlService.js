const isProd = false;

class UrlService {

    static AppUrl() {

        if (isProd) {
            return "https://going-recommendation-system.herokuapp.com"
        } else return "https://going.local";

    }

}


export default UrlService;