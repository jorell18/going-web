import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { Link } from 'react-router-dom';

class NavDropdown extends Component {

    constructor(props) {
        super(props);

    }

    handleLogout = (e) => {
        // e.preventDefault();
        // alert('logout');
        // console.log('handleLogout');
        // window.localStorage.clear();
        // localStorage.setItem('logout', 'naa man lage');
        // localStorage.setItem('appData',JSON.stringify(appState));
        // this.setState(appState);
        // window.localStorage.clear();
        this.props.logoutUser();
    }

    render() {
        if (this.props.appData.signedIn) {
            return (
                <div>
                    <div className="form-group">
                        <div onClick={this.handleLogout}>
                        <Link to="/login" className="form-control btn_full">Log out!</Link>
                        </div>
                    </div>
                </div>
            );
        } else {
            return (
                <div>
                    <div className="form-group">
                        <Link to="/login" className="form-control btn_full">Log in</Link>
                    </div>
                    <div className="form-group">
                        <Link to="/signup" className="form-control btn_full">Sign up </Link>
                    </div>
                </div>
            );
        }
    }
}

export default NavDropdown;