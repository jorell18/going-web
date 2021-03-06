import React, {useState, createContext}  from 'react';
import UrlService from '../services/UrlService'

export const AppContext = createContext();

export const AppProvider = props => {

        const [config, setConfig] = useState(
        {
            appURL : UrlService.AppUrl(),
            signedIn: false,
            token: ''
        }
        );

    return(
        <AppContext.Provider value={[config, setConfig]}>
           {props.children} 
        </AppContext.Provider>
    );

}