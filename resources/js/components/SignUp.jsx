import React, { Component, useContext } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import { Redirect, Link } from 'react-router-dom';
import { AppContext } from './AppContext';
import Navigation from './Navigation';
import $ from 'jquery';

class SignUp extends Component {
  // userData;

  constructor(props) {
    super(props);
    this.state = {
      signupData: {
        first_name: "",
        last_name: "",
        middle_name: "",
        email: "",
        password: "",
        confirm_password: "",
      },
      isLoading: false,
      alertClass: "",
      msg: "",
      status: "",
      signedIn: false,
    };
    this.onChangeHandler = this.onChangeHandler.bind(this);

    this.props.toggleElementById('navigation',0);
  }

  componentDidMount(){
    var exitButton = document.getElementsByClassName("mfp-close")[0];

    if(exitButton){
      this.simulateMouseClick(exitButton);
    }
    this.importPWstrengthJS();
  }

  
  simulateMouseClick(element){
  const mouseClickEvents = ['mousedown', 'click', 'mouseup'];

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
  }

  importPWstrengthJS(){
    
    const mainApp = document.getElementsByTagName('body')[0];

    const script4 = document.createElement("script");
    script4.async = true;
    script4.src = "panagea/js/pw_strenght.js";
    mainApp.appendChild(script4);
  }

  onChangeHandler = (e) => {
    const { signupData } = this.state;
    signupData[e.target.name] = e.target.value;
    this.setState({ signupData });
  }

  messageHandler = (e) => {
    var alert = document.getElementById("alert");
    if (this.state.msg === '') {
      alert.style.display = "none";
    }

  }


  onSubmitHandler = (e) => {
    e.preventDefault();

    this.setState({ isLoading: true });
    axios
      .post(this.props.appData.url + '/api/signup', this.state.signupData,
        {
          headers: {
            'Content-Type': 'application/json',

          }
        })
      .then((response) => {
        this.setState({
          isLoading: false,
          msg: response.data.message,
          status: response.data.status,
          signedIn: true,
          alertClass: "alert alert-success",
          signupData: {
            first_name: "",
            middle_name: "",
            last_name: "",
            email: "",
            password: "",
            confirm_password: "",
          },
        });

        this.props.setUserSignedIn(response.data.user, response.data.token);
      })
      .catch((error) => {
        console.log('status error');
        this.setState({
          isLoading: false,
          alertClass: "alert alert-danger",
          msg: error.response.data.message,
          status: error.response.data.status,
        });

      });
  };


  render() {
    var setToken = this.props.setToken;
    var setUserSignedIn = this.props.setUserSignedIn;
    const isLoading = this.state.isLoading;
    if (this.props.appData.signedIn) {
      if (this.props.appData.user.role === "admin") {
        return <Redirect to="/admin" appData={this.props.appData}> </Redirect>
      } else {
        return <Redirect to="/feed" appData={this.props.appData}> </Redirect>
      }
    }
    return (
      <div ref={el => (this.div = el)}>
        <div id="login">
          <aside>
            <figure>
              <a href="#"><img src="panagea/img/logo_sticky.png" width={155} height={36} data-retina="true" alt="" className="logo_sticky" /></a>
            </figure>
            <form autoComplete="off">
              <div className="form-group">
                <label>Your Name</label>
                <input className="form-control" type="text" name="first_name" value={this.state.signupData.first_name} onChange={this.onChangeHandler} />
                <i className="ti-user" />
              </div>
              <div className="form-group">
                <label>Your Middle Name</label>
                <input className="form-control" type="text" name="middle_name" value={this.state.signupData.middle_name} onChange={this.onChangeHandler} />
                <i className="ti-user" />
              </div>
              <div className="form-group">
                <label>Your Last Name</label>
                <input className="form-control" type="text" name="last_name" value={this.state.signupData.last_name} onChange={this.onChangeHandler} />
                <i className="ti-user" />
              </div>
              <div className="form-group">
                <label>Your Email</label>
                <input className="form-control" type="email" name="email" value={this.state.signupData.email} onChange={this.onChangeHandler} />
                <i className="icon_mail_alt" />
              </div>
              <div className="form-group">
                <label>Your password</label>
                <input className="form-control" type="password" id="password1" name="password" placeholder="Password" value={this.state.signupData.password} onChange={this.onChangeHandler} />
                <i className="icon_lock_alt" />
              </div>
              <div className="form-group">
                <label>Confirm password</label>
                <input className="form-control" type="password" id="password2" name="confirm_password" placeholder="Confirm password" value={this.state.signupData.confirm_password} onChange={this.onChangeHandler} />
                <i className="icon_lock_alt" />
              </div>
              <div id="pass-info" className="clearfix" />
              <button className="btn_1 rounded full-width add_top_30" onClick={this.onSubmitHandler} type="submit">Register Now!
              {
                  isLoading ? (
                    <span
                      className="icon-spin6 animate-spin"
                      role="status"
                      aria-hidden="true"
                    ></span>
                  ) : (
                      <span></span>
                    )
              }
              </button>
              <div className="text-center add_top_10">Already have an acccount? <strong><Link to="/login">Sign In</Link></strong></div>
            </form>
            <div className="copy">© 2020 Travelah</div>
          </aside>
        </div>
      </div>
    );
  }
}

export default SignUp;