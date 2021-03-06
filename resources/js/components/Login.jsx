import React, { useState, useContext, useEffect, Component } from 'react';
import ReactDOM from 'react-dom';
import { Link, Redirect } from 'react-router-dom';
import axios from 'axios';


class Login extends Component {

    constructor(props) {
        super(props);
        this.state = {
            signedIn: false,
            status: "",
            message: "",
            alertClass: "",
            isLoading: false,
            loginData: {
                email: "",
                password: "",
            },
        };

        //hide navbar
        this.props.toggleElementById('navigation',0);

    }

    componentDidMount() {
        var exitButton = document.getElementsByClassName("mfp-close")[0];

        if (exitButton) {
            this.simulateMouseClick(exitButton);
        }
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


    onChangeHandler = (e) => {
        const { loginData } = this.state;
        loginData[e.target.name] = e.target.value;
        this.setState({ loginData });
    }

    messageHandler = (e) => {
        var alert = document.getElementById("alert");
        if (this.state.message === '') {
            alert.style.display = "none";
        }

    }

    onSubmitHandler = (e) => {
        console.log('url',this.props.appData.url)
        e.preventDefault();

        this.setState({ isLoading: true });
        axios
            .post(this.props.appData.url + '/api/login', this.state.loginData)
            .then((response) => {
                this.setState({
                    isLoading: false,
                    message: response.data.message,
                    status: response.data.status,
                    userData: response.data.user,
                    alertClass: "alert alert-success",
                });

                console.log('response', response);
                this.props.setUserSignedIn(response.data.user, response.data.token);
            })
            .catch((error) => {
                console.log('status error');
                this.setState({
                    isLoading: false,
                    alertClass: "alert alert-danger",
                    message: error.response.data.message,
                    status: error.response.data.status,
                });
                alert(this.state.message);

            });


    }


    render() {
        const isLoading = this.state.isLoading;

        if (this.props.appData.signedIn) {
            if(this.props.appData.user.role === "admin"){
                return <Redirect to="/admin" appData={this.props.appData}> </Redirect>
            }else{
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
                        <form>
                            {/* <div className="access_social">
                                <a href="#0" className="social_bt facebook">Login with Facebook</a>
                                <a href="#0" className="social_bt google">Login with Google</a>
                                <a href="#0" className="social_bt linkedin">Login with Linkedin</a>
                            </div>
                            <div className="divider"><span>Or</span></div> */}
                            <div className="form-group">
                                <label>Email</label>
                                <input type="email" className="form-control" name="email" value={this.state.loginData.email} onChange={this.onChangeHandler} id="email" />
                                <i className="icon_mail_alt" />
                            </div>
                            <div className="form-group">
                                <label>Password</label>
                                <input type="password" className="form-control" name="password" value={this.state.loginData.password} onChange={this.onChangeHandler} id="password" />
                                <i className="icon_lock_alt" />
                            </div>
                            <div className="clearfix add_bottom_30">
                                <div className="checkboxes float-left">
                                    <label className="container_check">Remember me
                                            <input type="checkbox" />
                                        <span className="checkmark" />
                                    </label>
                                </div>
                                <div className="float-right mt-1"><a id="forgot" href="#">Forgot Password?</a></div>
                            </div>
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
                            <div className="text-center add_top_10">New to Panagea? <strong><Link to="/signup">Sign up!</Link></strong></div>
                        </form>
                        <div className="copy">© 2020 Travelah</div>
                    </aside>
                </div>

            </div>
        );
    }
}

export default Login;