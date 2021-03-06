import React, { Component , useContext, useEffect, useState} from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import { BrowserRouter as Router, Route, Switch, Redirect } from 'react-router-dom';
import {AppContext} from './AppContext';
import MainApp from './MainApp';
import NotFound from './NotFound';
import Feed from './Feed';
import Navigation from './Navigation';
import IndexContent from './IndexContent';
import Footer from './Footer';
import Login from './Login';
import SignUp from './SignUp';
import Admin from './Admin/Admin';

const AppComponent = () => {
  const [config, setConfig] = useContext(AppContext);

  console.log(config.appURL);

    return (
          <Router>
          <div>
              <Navigation />
              <main>
                  <Switch>
                      <Route exact path="/" component={IndexContent}/> 
                      <Route path="/login" component={Login}/> 
                      <Route path="/signup" component={SignUp} /> 
                      <Route path="/feed" component={Feed} />
                      <Route path="/admin" component={Admin} />
                      <Route path="*" component={NotFound} /> 
                  </Switch>
              </main>
              <Footer />
          </div>
      </Router>
    );
  // }
}

export default AppComponent;
