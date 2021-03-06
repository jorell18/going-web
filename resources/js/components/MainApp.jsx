import React, { useState, useContext, Component, createContext } from "react";
import ReactDOM from "react-dom";
import Navigation from "./Navigation";
import IndexContent from "./IndexContent";
import Login from "./Login";
import SignUp from "./SignUp";
import {
    BrowserRouter as Router,
    Route,
    Switch,
    useHistory,
    Redirect
} from "react-router-dom";
import NotFound from "./NotFound";
import Feed from "./Feed";
import Admin from "./Admin/Admin";
import UrlService from "../services/UrlService";
import Helmet from "react-helmet";

export class MainApp extends Component {
    constructor(props) {
        super(props);

        var storageAppData = {
            user: {
                traveler: {
                    first_name: ""
                }
            },
            token: "",
            signedIn: false,
            url: UrlService.AppUrl()
        };

        var storageData = JSON.parse(localStorage.getItem("appData"));
        // console.log('storageData', storageData);
        if (storageData) {
            if (storageData.signedIn) {
                console.log("has data", storageData);
                storageAppData = storageData;
            }
        } else {
            console.log("no data sizt");
        }

        console.log("storageAppData", storageData);

        this.state = {
            appData: storageAppData,
            script1: document.createElement("script"),
            script2: document.createElement("script"),
            script3: document.createElement("script"),
            script4: document.createElement("script")
        };

        // const baseStyle = document.getElementById('base-style');
        // baseStyle.href = 'panagea/css/style.css';

        var setToken = this.setToken.bind(this);
        var setUserSignedIn = this.setUserSignedIn.bind(this);
        var setUser = this.setUser.bind(this);
        var setAppData = this.setAppData.bind(this);
        var logoutUser = this.logoutUser.bind(this);
        var toggleElementById = this.toggleElementById.bind(this);

        this.state.script1.async = true;
        this.state.script1.src = "panagea/js/common_scripts.js";

        this.state.script2.async = true;
        this.state.script2.src = "panagea/js/main.js";

        this.state.script3.async = true;
        this.state.script3.src = "panagea/assets/validate.js";

        this.state.script3.async = true;
        this.state.script3.src = "panagea/js/modernizr.js";

        console.log("MinApp state", this.state);
    }

    componentDidMount() {
        console.log("main");
    }

    setToken = newToken => {
        this.setState(prevState => ({
            appData: {
                ...prevState.appData,
                token: newToken
            }
        }));
    };

    setUserSignedIn = (newUser, newToken) => {
        this.setState(prevState => ({
            appData: {
                ...prevState.appData,
                signedIn: true,
                user: newUser,
                token: newToken
            }
        }));

        localStorage.setItem("appData", JSON.stringify(this.state.appData));
        console.log("signed in");
    };

    setUser = newUser => {
        this.setState(prevState => ({
            appData: {
                ...prevState.appData,
                signedIn: true,
                user: newUser
            }
        }));
    };

    setAppData = newAppData => {
        console.log("set app data");
        console.log(newAppData);

        this.setState(prevState => ({
            appData: {
                ...prevState.appData,
                token: newAppData.token,
                signedIn: newAppData.signedIn,
                user: newAppData.user
            }
        }));
    };

    logoutUser = () => {
        console.log("logout");

        let appState = {
            appData: {
                user: {
                    traveler: {
                        first_name: ""
                    }
                },
                token: "",
                signedIn: false,
                url: UrlService.AppUrl()
            }
        };

        // window.localStorage.clear();
        localStorage.setItem("logout", "naa man lage");
        localStorage.setItem("appData", JSON.stringify(appState));
        this.setState(appState);
        // window.localStorage.clear();
    };

    importAPPJSfiles = () => {
        //import main.js for template
        const appJS = document.getElementById("app-js");
        appJS.appendChild(this.state.script1);
        appJS.appendChild(this.state.script2);
        appJS.appendChild(this.state.script3);
    };

    //hide element
    toggleElementById(elementID, show) {
        var visibility = show ? "visible" : "hidden";

        var element = document.getElementById(elementID);

        if (element) {
            element.style.visibility = visibility;
        } else {
            console.log("toggleElementById() - element not found", elementID);
        }
    }

    //used to close open modals
    simulateMouseClick = element => {
        const mouseClickEvents = ["mousedown", "click", "mouseup"];

        mouseClickEvents.forEach(mouseEventType =>
            element.dispatchEvent(
                new MouseEvent(mouseEventType, {
                    view: window,
                    bubbles: true,
                    cancelable: true,
                    buttons: 1
                })
            )
        );
    };

    render() {
        this.importAPPJSfiles();

        return (
            // <AppContext.Provider context={this.context}>
            <div id="page" ref={el => (this.div = el)}>
                <Helmet>
                    {/* Favicons*/}
                    <link
                        rel="shortcut icon"
                        href="panagea/img/favicon.ico"
                        type="image/x-icon"
                    />
                    <link
                        rel="apple-touch-icon"
                        type="image/x-icon"
                        href="panagea/img/apple-touch-icon-57x57-precomposed.png"
                    />
                    <link
                        rel="apple-touch-icon"
                        type="image/x-icon"
                        sizes="72x72"
                        href="panagea/img/apple-touch-icon-72x72-precomposed.png"
                    />
                    <link
                        rel="apple-touch-icon"
                        type="image/x-icon"
                        sizes="114x114"
                        href="panagea/img/apple-touch-icon-114x114-precomposed.png"
                    />
                    <link
                        rel="apple-touch-icon"
                        type="image/x-icon"
                        sizes="144x144"
                        href="panagea/img/apple-touch-icon-144x144-precomposed.png"
                    />
                    {/* GOOGLE WEB FONT */}
                    <link
                        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
                        rel="stylesheet"
                    />
                    {/* BASE CSS */}
                    <link
                        href="panagea/css/bootstrap.min.css"
                        rel="stylesheet"
                    />
                    <link
                        id="base-style"
                        href="panagea/css/style.css"
                        rel="stylesheet"
                    />
                    <link href="panagea/css/vendors.css" rel="stylesheet" />
                    {/* YOUR CUSTOM CSS */}
                    <link href="panagea/css/custom.css" rel="stylesheet" />
                    {/* COLOR THEME */}
                    {/* <link href="panagea/css/color-red.css" rel="stylesheet"> */}
                    {/* DATE RANGE PICKER */}
                    {/* <link href="panagea/css/daterangepicker.css" rel="stylesheet"> */}
                    {/* DATE PICKER */}
                    {/* <link href="panagea/admin_section/css/daterangepicker.css" rel="stylesheet"> */}
                </Helmet>
                <div id="preloader">
                    <div data-loader="circle-side"></div>
                </div>
                <Router>
                    <Navigation
                        appData={this.state.appData}
                        logoutUser={this.logoutUser.bind(this)}
                        setAppData={this.setAppData.bind(this)}
                        setUserSignedIn={this.setUserSignedIn.bind(this)}
                    />
                    <main>
                        <Switch>
                            <Route
                                exact
                                path="/"
                                render={props => (
                                    <IndexContent
                                        {...props}
                                        appData={this.state.appData}
                                        setToken={this.setToken.bind(this)}
                                        toggleElementById={this.toggleElementById.bind(
                                            this
                                        )}
                                    />
                                )}
                            />
                            <Route
                                path="/login"
                                render={props => (
                                    <Login
                                        {...props}
                                        appData={this.state.appData}
                                        setToken={this.setToken.bind(this)}
                                        setUserSignedIn={this.setUserSignedIn.bind(
                                            this
                                        )}
                                        setUser={this.setUser.bind(this)}
                                        toggleElementById={this.toggleElementById.bind(
                                            this
                                        )}
                                    />
                                )}
                            />
                            <Route
                                path="/signup"
                                render={props => (
                                    <SignUp
                                        {...props}
                                        appData={this.state.appData}
                                        setToken={this.setToken.bind(this)}
                                        setUserSignedIn={this.setUserSignedIn.bind(
                                            this
                                        )}
                                        setUser={this.setUser.bind(this)}
                                        toggleElementById={this.toggleElementById.bind(
                                            this
                                        )}
                                    />
                                )}
                            />
                            <Route
                                path="/feed"
                                render={props => (
                                    <Feed
                                        {...props}
                                        appData={this.state.appData}
                                        setToken={this.setToken.bind(this)}
                                        user={this.state.user}
                                        logoutUser={this.logoutUser.bind(this)}
                                        toggleElementById={this.toggleElementById.bind(
                                            this
                                        )}
                                    />
                                )}
                            />
                            <Route
                                path="/admin"
                                render={props => (
                                    <Admin
                                        {...props}
                                        appData={this.state.appData}
                                        setToken={this.setToken.bind(this)}
                                        user={this.state.user}
                                        logoutUser={this.logoutUser.bind(this)}
                                        toggleElementById={this.toggleElementById.bind(
                                            this
                                        )}
                                    />
                                )}
                            />
                            <Route path="*" component={NotFound} />
                        </Switch>
                    </main>
                </Router>
                {/* </AppContext.Provider> */}
            </div>
        );
    }
}

if (document.getElementById("main-app")) {
    ReactDOM.render(<MainApp />, document.getElementById("main-app"));
}
