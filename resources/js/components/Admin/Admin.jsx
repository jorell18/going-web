import React, { Component } from "react";
import ReactDOM from "react-dom";
import { Redirect, Link } from "react-router-dom";
import { Helmet } from "react-helmet";

class Admin extends Component {
    constructor(props) {
        super(props);

        this.state = {
            script1: document.createElement("script"),
            script2: document.createElement("script"),
            script3: document.createElement("script"),
            script4: document.createElement("script"),
            script5: document.createElement("script"),
            script6: document.createElement("script"),
            script7: document.createElement("script"),
            script8: document.createElement("script"),
            script9: document.createElement("script"),
            script10: document.createElement("script"),
            script11: document.createElement("script")
        };

        this.state.script1.async = true;
        this.state.script1.src =
            "panagea/admin_section/vendor/jquery/jquery.min.js";

        this.state.script2.async = true;
        this.state.script2.src =
            "panagea/admin_section/vendor/bootstrap/js/bootstrap.bundle.min.js";

        this.state.script3.async = true;
        this.state.script3.src =
            "panagea/admin_section/vendor/jquery-easing/jquery.easing.min.js";

        this.state.script4.async = true;
        this.state.script4.src =
            "panagea/admin_section/vendor/chart.js/Chart.js";

        this.state.script5.async = true;
        this.state.script5.src =
            "panagea/admin_section/vendor/datatables/jquery.dataTables.js";

        this.state.script6.async = true;
        this.state.script6.src =
            "panagea/admin_section/vendor/datatables/dataTables.bootstrap4.js";

        this.state.script7.async = true;
        this.state.script7.src =
            "panagea/admin_section/vendor/jquery.selectbox-0.2.js";

        this.state.script8.async = true;
        this.state.script8.src =
            "panagea/admin_section/vendor/retina-replace.min.js";

        this.state.script9.async = true;
        this.state.script9.src =
            "panagea/admin_section/vendor/jquery.magnific-popup.min.js";

        this.state.script10.async = true;
        this.state.script10.src = "panagea/admin_section/js/admin.js";

        this.state.script11.async = true;
        this.state.script11.src = "panagea/admin_section/js/admin-charts.js";

        //change base style for admin section
        // const baseStyle = document.getElementById('base-style');
        // baseStyle.href = 'panagea/admin_section/css/admin.css';
    }

    componentDidMount() {
        console.log("admin");
        //remove javascript files from app-js element
        const appJS = document.getElementById("app-js");
        while (appJS.firstChild) {
            appJS.removeChild(appJS.lastChild);
        }

        //import JS files
        // this.importAdminJSFiles();

        //move modal to before body end tag
        var modal = document.getElementById("exampleModal");
        var body = document.getElementsByTagName("body")[0];

        if (modal) {
            console.log("modal", modal);
            body.appendChild(modal);
        }
    }

    handleLogout = e => {
        console.log("admin logout");
        //if nav was open, simulate click on the exit button on the modal
        var exitButton = document.getElementById("exit-button");
        if (exitButton) {
            this.simulateMouseClick(exitButton);
        }

        this.props.logoutUser();
    };

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

    importAdminJSFiles() {
        //import admin js files
        const adminJS = document.getElementById("admin-js");
        adminJS.appendChild(this.state.script1);
        adminJS.appendChild(this.state.script2);
        adminJS.appendChild(this.state.script3);
        adminJS.appendChild(this.state.script4);
        adminJS.appendChild(this.state.script5);
        adminJS.appendChild(this.state.script6);
        adminJS.appendChild(this.state.script7);
        adminJS.appendChild(this.state.script8);
        adminJS.appendChild(this.state.script9);
        adminJS.appendChild(this.state.script10);
        adminJS.appendChild(this.state.script11);
    }

    render() {
        if (!this.props.appData.signedIn) {
            return (
                <Redirect to="/" appData={this.props.appData}>
                    {" "}
                </Redirect>
            );
        }

        return (
            <div>
                <Helmet>
                    <title>PANAGEA - Admin dashboard</title>
                    {/* Favicons*/}
                    <link
                        rel="shortcut icon"
                        href="panagea/admin_section/img/favicon.ico"
                        type="image/x-icon"
                    />
                    <link
                        rel="apple-touch-icon"
                        type="panagea/image/x-icon"
                        href="panagea/admin_section/img/apple-touch-icon-57x57-precomposed.png"
                    />
                    <link
                        rel="apple-touch-icon"
                        type="panagea/image/x-icon"
                        sizes="72x72"
                        href="panagea/admin_section/img/apple-touch-icon-72x72-precomposed.png"
                    />
                    <link
                        rel="apple-touch-icon"
                        type="panagea/image/x-icon"
                        sizes="114x114"
                        href="panagea/admin_section/img/apple-touch-icon-114x114-precomposed.png"
                    />
                    <link
                        rel="apple-touch-icon"
                        type="panagea/image/x-icon"
                        sizes="144x144"
                        href="panagea/admin_section/img/apple-touch-icon-144x144-precomposed.png"
                    />

                    <link
                        id="base-style"
                        href="panagea/admin_section/css/admin.css"
                        rel="stylesheet"
                    />

                    {/* <!-- Bootstrap core CSS--> */}
                    <link
                        href="panagea/admin_section/vendor/bootstrap/css/bootstrap.min.css"
                        rel="stylesheet"
                    />
                    {/* <!-- Main styles --> */}
                    <link
                        href="panagea/admin_section/css/admin.css"
                        rel="stylesheet"
                    />
                    {/* <!-- Icon fonts--> */}
                    <link
                        href="panagea/admin_section/vendor/font-awesome/css/font-awesome.min.css"
                        rel="stylesheet"
                        type="text/css"
                    />
                    {/* <!-- Plugin styles --> */}
                    <link
                        href="panagea/admin_section/vendor/datatables/dataTables.bootstrap4.css"
                        rel="stylesheet"
                    />
                    {/* <!-- Your custom styles --> */}
                    <link
                        href="panagea/admin_section/css/custom.css"
                        rel="stylesheet"
                    ></link>
                </Helmet>
                <div>
                    {/* Navigation*/}
                    <nav
                        className="navbar navbar-expand-lg navbar-dark bg-default fixed-top"
                        id="mainNav"
                    >
                        <a className="navbar-brand" href="index.html">
                            <img
                                src="panagea/admin_section/img/logo.png"
                                data-retina="true"
                                width={150}
                                height={36}
                            />
                        </a>
                        <button
                            className="navbar-toggler navbar-toggler-right"
                            type="button"
                            data-toggle="collapse"
                            data-target="#navbarResponsive"
                            aria-controls="navbarResponsive"
                            aria-expanded="false"
                            aria-label="Toggle navigation"
                        >
                            <span className="navbar-toggler-icon" />
                        </button>
                        <div
                            className="collapse navbar-collapse"
                            id="navbarResponsive"
                        >
                            <ul
                                className="navbar-nav navbar-sidenav"
                                id="exampleAccordion"
                            >
                                <li
                                    className="nav-item"
                                    data-toggle="tooltip"
                                    data-placement="right"
                                    title="Dashboard"
                                >
                                    <a className="nav-link" href="index.html">
                                        <i className="fa fa-fw fa-dashboard" />
                                        <span className="nav-link-text">
                                            Dashboard
                                        </span>
                                    </a>
                                </li>
                                <li
                                    className="nav-item"
                                    data-toggle="tooltip"
                                    data-placement="right"
                                    title="Messages"
                                >
                                    <a
                                        className="nav-link"
                                        href="messages.html"
                                    >
                                        <i className="fa fa-fw fa-envelope-open" />
                                        <span className="nav-link-text">
                                            Messages
                                        </span>
                                    </a>
                                </li>
                                <li
                                    className="nav-item"
                                    data-toggle="tooltip"
                                    data-placement="right"
                                    data-original-title="Bookings"
                                >
                                    <a
                                        className="nav-link"
                                        href="bookings.html"
                                    >
                                        <i className="fa fa-fw fa-calendar-check-o" />
                                        <span className="nav-link-text">
                                            Bookings{" "}
                                            <span className="badge badge-pill badge-primary">
                                                6 New
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li
                                    className="nav-item"
                                    data-toggle="tooltip"
                                    data-placement="right"
                                    title="My listings"
                                >
                                    <a
                                        className="nav-link nav-link-collapse collapsed"
                                        data-toggle="collapse"
                                        href="#collapseMylistings"
                                        data-parent="#mylistings"
                                    >
                                        <i className="fa fa-fw fa-list" />
                                        <span className="nav-link-text">
                                            My listings
                                        </span>
                                    </a>
                                    <ul
                                        className="sidenav-second-level collapse"
                                        id="collapseMylistings"
                                    >
                                        <li>
                                            <a href="listings.html">
                                                Pending{" "}
                                                <span className="badge badge-pill badge-primary">
                                                    6
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="listings.html">
                                                Active{" "}
                                                <span className="badge badge-pill badge-success">
                                                    6
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="listings.html">
                                                Expired{" "}
                                                <span className="badge badge-pill badge-danger">
                                                    6
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li
                                    className="nav-item"
                                    data-toggle="tooltip"
                                    data-placement="right"
                                    title="Reviews"
                                >
                                    <a className="nav-link" href="reviews.html">
                                        <i className="fa fa-fw fa-star" />
                                        <span className="nav-link-text">
                                            Reviews
                                        </span>
                                    </a>
                                </li>
                                <li
                                    className="nav-item"
                                    data-toggle="tooltip"
                                    data-placement="right"
                                    title="Bookmarks"
                                >
                                    <a
                                        className="nav-link"
                                        href="bookmarks.html"
                                    >
                                        <i className="fa fa-fw fa-heart" />
                                        <span className="nav-link-text">
                                            Bookmarks
                                        </span>
                                    </a>
                                </li>
                                <li
                                    className="nav-item"
                                    data-toggle="tooltip"
                                    data-placement="right"
                                    title="Add listing"
                                >
                                    <a
                                        className="nav-link"
                                        href="add-listing.html"
                                    >
                                        <i className="fa fa-fw fa-plus-circle" />
                                        <span className="nav-link-text">
                                            Add listing
                                        </span>
                                    </a>
                                </li>
                                <li
                                    className="nav-item"
                                    data-toggle="tooltip"
                                    data-placement="right"
                                    title="My profile"
                                >
                                    <a
                                        className="nav-link"
                                        href="user-profile.html"
                                    >
                                        <i className="fa fa-fw fa-user" />
                                        <span className="nav-link-text">
                                            My Profile
                                        </span>
                                    </a>
                                </li>
                                <li
                                    className="nav-item"
                                    data-toggle="tooltip"
                                    data-placement="right"
                                    title="Components"
                                >
                                    <a
                                        className="nav-link nav-link-collapse collapsed"
                                        data-toggle="collapse"
                                        href="#collapseComponents"
                                        data-parent="#Components"
                                    >
                                        <i className="fa fa-fw fa-gear" />
                                        <span className="nav-link-text">
                                            Components
                                        </span>
                                    </a>
                                    <ul
                                        className="sidenav-second-level collapse"
                                        id="collapseComponents"
                                    >
                                        <li>
                                            <a href="charts.html">Charts</a>
                                        </li>
                                        <li>
                                            <a href="tables.html">Tables</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <ul className="navbar-nav sidenav-toggler">
                                <li className="nav-item">
                                    <a
                                        className="nav-link text-center"
                                        id="sidenavToggler"
                                    >
                                        <i className="fa fa-fw fa-angle-left" />
                                    </a>
                                </li>
                            </ul>
                            <ul className="navbar-nav ml-auto">
                                <li className="nav-item dropdown">
                                    <a
                                        className="nav-link dropdown-toggle mr-lg-2"
                                        id="messagesDropdown"
                                        href="#"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        <i className="fa fa-fw fa-envelope" />
                                        <span className="d-lg-none">
                                            Messages
                                            <span className="badge badge-pill badge-primary">
                                                12 New
                                            </span>
                                        </span>
                                        <span className="indicator text-primary d-none d-lg-block">
                                            <i className="fa fa-fw fa-circle" />
                                        </span>
                                    </a>
                                    <div
                                        className="dropdown-menu"
                                        aria-labelledby="messagesDropdown"
                                    >
                                        <h6 className="dropdown-header">
                                            New Messages:
                                        </h6>
                                        <div className="dropdown-divider" />
                                        <a className="dropdown-item" href="#">
                                            <strong>David Miller</strong>
                                            <span className="small float-right text-muted">
                                                11:21 AM
                                            </span>
                                            <div className="dropdown-message small">
                                                Hey there! This new version of
                                                SB Admin is pretty awesome!
                                                These messages clip off when
                                                they reach the end of the box so
                                                they don't overflow over to the
                                                sides!
                                            </div>
                                        </a>
                                        <div className="dropdown-divider" />
                                        <a className="dropdown-item" href="#">
                                            <strong>Jane Smith</strong>
                                            <span className="small float-right text-muted">
                                                11:21 AM
                                            </span>
                                            <div className="dropdown-message small">
                                                I was wondering if you could
                                                meet for an appointment at 3:00
                                                instead of 4:00. Thanks!
                                            </div>
                                        </a>
                                        <div className="dropdown-divider" />
                                        <a className="dropdown-item" href="#">
                                            <strong>John Doe</strong>
                                            <span className="small float-right text-muted">
                                                11:21 AM
                                            </span>
                                            <div className="dropdown-message small">
                                                I've sent the final files over
                                                to you for review. When you're
                                                able to sign off of them let me
                                                know and we can discuss
                                                distribution.
                                            </div>
                                        </a>
                                        <div className="dropdown-divider" />
                                        <a
                                            className="dropdown-item small"
                                            href="#"
                                        >
                                            View all messages
                                        </a>
                                    </div>
                                </li>
                                <li className="nav-item dropdown">
                                    <a
                                        className="nav-link dropdown-toggle mr-lg-2"
                                        id="alertsDropdown"
                                        href="#"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        <i className="fa fa-fw fa-bell" />
                                        <span className="d-lg-none">
                                            Alerts
                                            <span className="badge badge-pill badge-warning">
                                                6 New
                                            </span>
                                        </span>
                                        <span className="indicator text-warning d-none d-lg-block">
                                            <i className="fa fa-fw fa-circle" />
                                        </span>
                                    </a>
                                    <div
                                        className="dropdown-menu"
                                        aria-labelledby="alertsDropdown"
                                    >
                                        <h6 className="dropdown-header">
                                            New Alerts:
                                        </h6>
                                        <div className="dropdown-divider" />
                                        <a className="dropdown-item" href="#">
                                            <span className="text-success">
                                                <strong>
                                                    <i className="fa fa-long-arrow-up fa-fw" />
                                                    Status Update
                                                </strong>
                                            </span>
                                            <span className="small float-right text-muted">
                                                11:21 AM
                                            </span>
                                            <div className="dropdown-message small">
                                                This is an automated server
                                                response message. All systems
                                                are online.
                                            </div>
                                        </a>
                                        <div className="dropdown-divider" />
                                        <a className="dropdown-item" href="#">
                                            <span className="text-danger">
                                                <strong>
                                                    <i className="fa fa-long-arrow-down fa-fw" />
                                                    Status Update
                                                </strong>
                                            </span>
                                            <span className="small float-right text-muted">
                                                11:21 AM
                                            </span>
                                            <div className="dropdown-message small">
                                                This is an automated server
                                                response message. All systems
                                                are online.
                                            </div>
                                        </a>
                                        <div className="dropdown-divider" />
                                        <a className="dropdown-item" href="#">
                                            <span className="text-success">
                                                <strong>
                                                    <i className="fa fa-long-arrow-up fa-fw" />
                                                    Status Update
                                                </strong>
                                            </span>
                                            <span className="small float-right text-muted">
                                                11:21 AM
                                            </span>
                                            <div className="dropdown-message small">
                                                This is an automated server
                                                response message. All systems
                                                are online.
                                            </div>
                                        </a>
                                        <div className="dropdown-divider" />
                                        <a
                                            className="dropdown-item small"
                                            href="#"
                                        >
                                            View all alerts
                                        </a>
                                    </div>
                                </li>
                                <li className="nav-item">
                                    <form className="form-inline my-2 my-lg-0 mr-lg-2">
                                        <div className="input-group">
                                            <input
                                                className="form-control search-top"
                                                type="text"
                                                placeholder="Search for..."
                                            />
                                            <span className="input-group-btn">
                                                <button
                                                    className="btn btn-primary"
                                                    type="button"
                                                >
                                                    <i className="fa fa-search" />
                                                </button>
                                            </span>
                                        </div>
                                    </form>
                                </li>
                                <li className="nav-item">
                                    <a
                                        className="nav-link"
                                        data-toggle="modal"
                                        data-target="#exampleModal"
                                    >
                                        <i className="fa fa-fw fa-sign-out" />
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    {/* /Navigation*/}
                    <div className="content-wrapper">
                        <div className="container-fluid">
                            {/* Breadcrumbs*/}
                            <ol className="breadcrumb">
                                <li className="breadcrumb-item">
                                    <a href="#">Dashboard</a>
                                </li>
                                <li className="breadcrumb-item active">
                                    My Dashboard
                                </li>
                            </ol>
                            {/* Icon Cards*/}
                            <div className="row">
                                <div className="col-xl-3 col-sm-6 mb-3">
                                    <div className="card dashboard text-white bg-primary o-hidden h-100">
                                        <div className="card-body">
                                            <div className="card-body-icon">
                                                <i className="fa fa-fw fa-envelope-open" />
                                            </div>
                                            <div className="mr-5">
                                                <h5>26 New Messages!</h5>
                                            </div>
                                        </div>
                                        <a
                                            className="card-footer text-white clearfix small z-1"
                                            href="messages.html"
                                        >
                                            <span className="float-left">
                                                View Details
                                            </span>
                                            <span className="float-right">
                                                <i className="fa fa-angle-right" />
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <div className="col-xl-3 col-sm-6 mb-3">
                                    <div className="card dashboard text-white bg-warning o-hidden h-100">
                                        <div className="card-body">
                                            <div className="card-body-icon">
                                                <i className="fa fa-fw fa-star" />
                                            </div>
                                            <div className="mr-5">
                                                <h5>11 New Reviews!</h5>
                                            </div>
                                        </div>
                                        <a
                                            className="card-footer text-white clearfix small z-1"
                                            href="reviews.html"
                                        >
                                            <span className="float-left">
                                                View Details
                                            </span>
                                            <span className="float-right">
                                                <i className="fa fa-angle-right" />
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <div className="col-xl-3 col-sm-6 mb-3">
                                    <div className="card dashboard text-white bg-success o-hidden h-100">
                                        <div className="card-body">
                                            <div className="card-body-icon">
                                                <i className="fa fa-fw fa-calendar-check-o" />
                                            </div>
                                            <div className="mr-5">
                                                <h5>10 New Bookings!</h5>
                                            </div>
                                        </div>
                                        <a
                                            className="card-footer text-white clearfix small z-1"
                                            href="bookings.html"
                                        >
                                            <span className="float-left">
                                                View Details
                                            </span>
                                            <span className="float-right">
                                                <i className="fa fa-angle-right" />
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <div className="col-xl-3 col-sm-6 mb-3">
                                    <div className="card dashboard text-white bg-danger o-hidden h-100">
                                        <div className="card-body">
                                            <div className="card-body-icon">
                                                <i className="fa fa-fw fa-heart" />
                                            </div>
                                            <div className="mr-5">
                                                <h5>10 New Bookmarks!</h5>
                                            </div>
                                        </div>
                                        <a
                                            className="card-footer text-white clearfix small z-1"
                                            href="bookmarks.html"
                                        >
                                            <span className="float-left">
                                                View Details
                                            </span>
                                            <span className="float-right">
                                                <i className="fa fa-angle-right" />
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            {/* /cards */}
                            <h2 />
                            <div className="box_general padding_bottom">
                                <div className="header_box version_2">
                                    <h2>
                                        <i className="fa fa-bar-chart" />
                                        Statistic
                                    </h2>
                                </div>
                                <canvas
                                    id="myAreaChart"
                                    width="100%"
                                    height={30}
                                    style={{ margin: "45px 0 15px 0" }}
                                />
                            </div>
                        </div>
                        {/* /.container-fluid*/}
                    </div>
                    {/* /.container-wrapper*/}
                    <footer className="sticky-footer">
                        <div className="container">
                            <div className="text-center">
                                <small>Copyright © PANAGEA 2018</small>
                            </div>
                        </div>
                    </footer>
                    {/* Scroll to Top Button*/}
                    <a className="scroll-to-top rounded" href="#page-top">
                        <i className="fa fa-angle-up" />
                    </a>
                    {/* Logout Modal*/}
                    <div
                        className="modal fade"
                        id="exampleModal"
                        tabIndex={-1}
                        role="dialog"
                        aria-labelledby="exampleModalLabel"
                        aria-hidden="true"
                    >
                        <div className="modal-dialog" role="document">
                            <div className="modal-content">
                                <div className="modal-header">
                                    <h5
                                        className="modal-title"
                                        id="exampleModalLabel"
                                    >
                                        Ready to Leave?
                                    </h5>
                                    <button
                                        id="exit-button"
                                        className="close"
                                        type="button"
                                        data-dismiss="modal"
                                        aria-label="Close"
                                    >
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div className="modal-body">
                                    Select "Logout" below if you are ready to
                                    end your current session.
                                </div>
                                <div className="modal-footer">
                                    <button
                                        className="btn btn-secondary"
                                        type="button"
                                        data-dismiss="modal"
                                    >
                                        Cancel
                                    </button>
                                    <Link
                                        to="/"
                                        onClick={this.handleLogout}
                                        className="btn btn-primary"
                                    >
                                        Logout
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Admin;
