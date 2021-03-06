import React, { useState, useContext, useEffect, Component } from 'react';
import ReactDOM from 'react-dom';
import { Link } from 'react-router-dom';
import { AppContext } from './AppContext';
import { set } from 'lodash';
import NavDropdown from './NavDropdown';


class Navigation extends Component {

  constructor(props) {
    super(props);
    this.state = {
      signedIn: false,
      status: "",
      message: "",
      errorMessage: [""],
      alertClass: "",
      isLoading: false,
      navLoginData: {
        email: "",
        password: "",
        name: ""

      }
    };

  }


  componentDidMount() {
    console.log('Navigation props', this.props);

  }

  handleLogout = (e) => {
    //if nav was open, simulate click on the exit button on the modal
    var exitButton = document.getElementsByClassName("mfp-close")[0];
    if (exitButton) {
      this.simulateMouseClick(exitButton);
    }

    this.props.logoutUser();
  }

  onChangeHandler = (e) => {
    const { navLoginData } = this.state;
    navLoginData[e.target.name] = e.target.value;
    this.setState({ navLoginData });
  }

  messageHandler = (e) => {
    var alert = document.getElementById("alert");
    if (this.state.message === '') {
      alert.style.display = "none";
    }
  }

  onSubmitHandler = (e) => {
    console.log('url', this.props.appData.url)
    e.preventDefault();

    this.setState({
      isLoading: true
    });

    axios
      .post(this.props.appData.url + '/api/login', this.state.navLoginData)
      .then((response) => {
        this.setState({
          isLoading: false,
          message: "Login Success!",
          status: response.data.status,
          userData: response.data.user,
          alertClass: "alert alert-success"
        }
        );

        this.props.setUserSignedIn(response.data.user, response.data.token);

        console.log('response', response);
      })
      .catch((error) => {
        console.log('response error', error);
        this.setState({
          isLoading: false,
          alertClass: "alert alert-danger",
          errorMessage: error.response.data.message,
          status: error.response.data.status
        }
        );
      });
  }

  render() {
    const isLoading = this.state.isLoading;

    const errorMessages = this.state.errorMessage.map(
      (message) =>
        <div key={message}><span>{message}</span><br /></div>
    );

    var name = "";

    if (this.props.appData.user.traveler.first_name) {
      name = this.props.appData.user.traveler.first_name;
    }

    return (
      <div>
        <div>
          <header id="navigation" className="header menu_fixed" onChange={this.handleOnchange} style={this.props.appData.user.role === "admin" ? { visibility: 'hidden' } : { visibility: 'visible' }}>
            <div id="logo">
              <a href="index.html">
                <img src="panagea/img/logo.svg" width={150} height={36} alt="" className="logo_normal" />
                <img src="panagea/img/logo_sticky.svg" width={150} height={36} alt="" className="logo_sticky" />
              </a>
            </div>
            {/* <ul id="top_menu">
              <li><a href="#sign-in-dialog" id="sign-in" className="login" title="Sign In">Sign In</a></li>
            </ul> */}
            {/* /top_menu */}
            <a href="#menu" className="btn_mobile">
              <div className="hamburger hamburger--collapse" id="hamburger">
                <div className="hamburger-box">
                  <div className="hamburger-inner" />
                </div>
              </div>
            </a>


            <nav id="menu" className="main-menu">
              <ul>
                {/* <li className="navigation-menu-signed-in">
                  <span></span>
                </li> */}
                <li className="navigation-menu-signed-in" style={this.props.appData.signedIn ? { display: 'inline-block' } : { display: 'none' }}>
                  <span><a>{name}</a></span>
                </li>
                <li className="navigation-menu-signed-in" style={this.props.appData.signedIn ? { display: 'inline-block' } : { display: 'none' }}>
                  <span><a>Settings</a></span>
                </li>
                <li className="navigation-menu-signed-in" style={this.props.appData.signedIn ? { display: 'inline-block' } : { display: 'none' }}>
                  <span><Link to="/" onClick={this.handleLogout} >Logout<span className="icon-logout"></span></Link></span>
                </li>
                <li id="sign-in-button" style={this.props.appData.signedIn ? { display: 'none' } : { display: 'inline-block' }}>
                  <span><a href="#sign-in-dialog" id="sign-in" className="login" title="Sign In"><span className="icon-login-1"></span>Sign In</a></span>
                </li>
              </ul>
            </nav>

          </header>

          {/* Sign In Popup */}
          <div id="sign-in-dialog" className="zoom-anim-dialog mfp-hide">
            <div className="small-dialog-header">
              <h3>Sign In</h3>
            </div>
            <div className="text-center">
              <span>
                {errorMessages}
              </span>
            </div>
            <form>
              <div className="sign-in-wrapper">
                {/* <a href="#0" className="social_bt facebook">Login with Facebook</a>
              <a href="#0" className="social_bt google">Login with Google</a>
              <div className="divider"><span>Or</span></div> */}
                <div className="form-group">
                  <label>Email</label>
                  <input type="email" className="form-control" name="email" value={this.state.navLoginData.email} onChange={this.onChangeHandler} id="email" />
                  <i className="icon_mail_alt" />
                </div>
                <div className="form-group">
                  <label>Password</label>
                  <input type="password" className="form-control" name="password" value={this.state.navLoginData.password} onChange={this.onChangeHandler} id="password" />
                  <i className="icon_lock_alt" />
                </div>
                <div className="clearfix add_bottom_15">
                  <div className="checkboxes float-left">
                    <label className="container_check">Remember me
                      <input type="checkbox" />
                      <span className="checkmark" />
                    </label>
                  </div>
                  <div className="float-right mt-1"><a id="forgot" href="#">Forgot Password?</a></div>
                </div>
                <div className="text-center">
                  <button className="btn_1 rounded full-width" onClick={this.onSubmitHandler} type="submit">Login to Travelah
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
                </div>
                <div className="text-center">
                  Don’t have an account? <Link to="/signup">Sign up</Link>
                </div>
                {/* <div id="forgot_pw">
                  <div className="form-group">
                    <label>Please confirm login email below</label>
                    <input type="email" className="form-control" name="email_forgot" id="email_forgot" />
                    <i className="icon_mail_alt" />
                  </div>
                  <p>You will receive an email containing a link allowing you to reset your password to a new preferred one.</p>
                  <div className="text-center"><input type="submit" defaultValue="Reset Password" className="btn_1" /></div>
                </div> */}
              </div>
            </form>
          </div>
        </div>
      </div>
    );
  }

}

export default Navigation;