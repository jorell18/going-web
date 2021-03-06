import React, { useState, useContext, Component } from "react";
import ReactDOM from "react-dom";
import AppContext from "./AppContext";
import { Redirect } from "react-router-dom";
import Footer from "./Footer";
import { Helmet } from "react-helmet";

class IndexContent extends Component {
    constructor(props) {
        super(props);
    }

    componentDidMount() {
        console.log("index");
        console.log("Index props", this.props);
        //check if localStorage has data
        var storageData = JSON.parse(localStorage.getItem("appData"));
        if (localStorage.getItem("appData")) {
            console.log("has data", storageData);
            this.setState({ appData: storageData.appData });
        } else {
            console.log("no data");
        }

        //remove javascript files from admin-js element
        // const adminJS = document.getElementById('admin-js');
        // while (adminJS.firstChild) {
        //   adminJS.removeChild(adminJS.lastChild);
        // }
    }

    simulateMouseClick(element) {
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
    }

    render() {
        var setToken = this.props.setToken;

        if (this.props.appData.signedIn) {
            var exitButton = document.getElementsByClassName("mfp-close")[0];
            if (exitButton) {
                this.simulateMouseClick(exitButton);
            }

            if (this.props.appData.user.role === "admin") {
                console.log("signed in as admin");
                //hide navbar
                this.props.toggleElementById("navigation", 0);
                return (
                    <Redirect to="/admin" appData={this.props.appData}>
                        {" "}
                    </Redirect>
                );
            } else if (this.props.appData.user.role === "user") {
                console.log("signed in as user");

                return (
                    <Redirect to="/feed" appData={this.props.appData}>
                        {" "}
                    </Redirect>
                );
            }
        }
        return (
            <div ref={el => (this.div = el)}>
                <section className="header-video">
                    <div id="hero_video">
                        <div className="wrapper">
                            <div className="container">
                                <h3>Visit your favorite cities</h3>
                                <p>with popular places recommended for you</p>
                            </div>
                        </div>
                    </div>
                    <img
                        src="panagea/img/video_fix.png"
                        alt=""
                        className="header-video--media"
                        data-video-src="panagea/video/intro"
                        data-teaser-source="panagea/video/intro"
                        data-provider
                        data-video-width={1920}
                        data-video-height={960}
                    />
                </section>
                {/* /header-video */}
                <div className="container container-custom margin_80_0">
                    <div className="main_title_2">
                        <span>
                            <em />
                        </span>
                        <h2>Our Popular Tours</h2>
                        <p>
                            Cum doctus civibus efficiantur in imperdiet
                            deterruisset.
                        </p>
                    </div>
                    <div id="reccomended" className="owl-carousel owl-theme">
                        <div className="item">
                            <div className="box_grid">
                                <figure>
                                    <a href="#0" className="wish_bt" />
                                    <a href="tour-detail.html">
                                        <img
                                            src="panagea/img/tour_1.jpg"
                                            className="img-fluid"
                                            alt=""
                                            width={800}
                                            height={533}
                                        />
                                        <div className="read_more">
                                            <span>Read more</span>
                                        </div>
                                    </a>
                                    <small>Historic</small>
                                </figure>
                                <div className="wrapper">
                                    <h3>
                                        <a href="tour-detail.html">
                                            Arc Triomphe
                                        </a>
                                    </h3>
                                    <p>
                                        Id placerat tacimates definitionem sea,
                                        prima quidam vim no. Duo nobis persecuti
                                        cu.
                                    </p>
                                    <span className="price">
                                        From <strong>$54</strong> /per person
                                    </span>
                                </div>
                                <ul>
                                    <li>
                                        <i className="icon_clock_alt" /> 1h
                                        30min
                                    </li>
                                    <li>
                                        <div className="score">
                                            <span>
                                                Superb<em>350 Reviews</em>
                                            </span>
                                            <strong>8.9</strong>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        {/* /item */}
                        <div className="item">
                            <div className="box_grid">
                                <figure>
                                    <a href="#0" className="wish_bt" />
                                    <a href="tour-detail.html">
                                        <img
                                            src="panagea/img/tour_2.jpg"
                                            className="img-fluid"
                                            alt=""
                                            width={800}
                                            height={533}
                                        />
                                        <div className="read_more">
                                            <span>Read more</span>
                                        </div>
                                    </a>
                                    <small>Churches</small>
                                </figure>
                                <div className="wrapper">
                                    <h3>
                                        <a href="tour-detail.html">Notredam</a>
                                    </h3>
                                    <p>
                                        Id placerat tacimates definitionem sea,
                                        prima quidam vim no. Duo nobis persecuti
                                        cu.
                                    </p>
                                    <span className="price">
                                        From <strong>$124</strong> /per person
                                    </span>
                                </div>
                                <ul>
                                    <li>
                                        <i className="icon_clock_alt" /> 1h
                                        30min
                                    </li>
                                    <li>
                                        <div className="score">
                                            <span>
                                                Good<em>350 Reviews</em>
                                            </span>
                                            <strong>7.0</strong>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        {/* /item */}
                        <div className="item">
                            <div className="box_grid">
                                <figure>
                                    <a href="#0" className="wish_bt" />
                                    <a href="tour-detail.html">
                                        <img
                                            src="panagea/img/tour_3.jpg"
                                            className="img-fluid"
                                            alt=""
                                            width={800}
                                            height={533}
                                        />
                                        <div className="read_more">
                                            <span>Read more</span>
                                        </div>
                                    </a>
                                    <small>Historic</small>
                                </figure>
                                <div className="wrapper">
                                    <h3>
                                        <a href="tour-detail.html">
                                            Versailles
                                        </a>
                                    </h3>
                                    <p>
                                        Id placerat tacimates definitionem sea,
                                        prima quidam vim no. Duo nobis persecuti
                                        cu.
                                    </p>
                                    <span className="price">
                                        From <strong>$25</strong> /per person
                                    </span>
                                </div>
                                <ul>
                                    <li>
                                        <i className="icon_clock_alt" /> 1h
                                        30min
                                    </li>
                                    <li>
                                        <div className="score">
                                            <span>
                                                Good<em>350 Reviews</em>
                                            </span>
                                            <strong>7.0</strong>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        {/* /item */}
                        <div className="item">
                            <div className="box_grid">
                                <figure>
                                    <a href="#0" className="wish_bt" />
                                    <a href="tour-detail.html">
                                        <img
                                            src="panagea/img/tour_3.jpg"
                                            className="img-fluid"
                                            alt=""
                                            width={800}
                                            height={533}
                                        />
                                        <div className="read_more">
                                            <span>Read more</span>
                                        </div>
                                    </a>
                                    <small>Historic</small>
                                </figure>
                                <div className="wrapper">
                                    <h3>
                                        <a href="tour-detail.html">
                                            Versailles
                                        </a>
                                    </h3>
                                    <p>
                                        Id placerat tacimates definitionem sea,
                                        prima quidam vim no. Duo nobis persecuti
                                        cu.
                                    </p>
                                    <span className="price">
                                        From <strong>$25</strong> /per person
                                    </span>
                                </div>
                                <ul>
                                    <li>
                                        <i className="icon_clock_alt" /> 1h
                                        30min
                                    </li>
                                    <li>
                                        <div className="score">
                                            <span>
                                                Good<em>350 Reviews</em>
                                            </span>
                                            <strong>7.0</strong>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        {/* /item */}
                        <div className="item">
                            <div className="box_grid">
                                <figure>
                                    <a href="#0" className="wish_bt" />
                                    <a href="tour-detail.html">
                                        <img
                                            src="panagea/img/tour_4.jpg"
                                            className="img-fluid"
                                            alt=""
                                            width={800}
                                            height={533}
                                        />
                                        <div className="read_more">
                                            <span>Read more</span>
                                        </div>
                                    </a>
                                    <small>Museum</small>
                                </figure>
                                <div className="wrapper">
                                    <h3>
                                        <a href="tour-detail.html">
                                            Pompidue Museum
                                        </a>
                                    </h3>
                                    <p>
                                        Id placerat tacimates definitionem sea,
                                        prima quidam vim no. Duo nobis persecuti
                                        cu.
                                    </p>
                                    <span className="price">
                                        From <strong>$45</strong> /per person
                                    </span>
                                </div>
                                <ul>
                                    <li>
                                        <i className="icon_clock_alt" /> 2h
                                        30min
                                    </li>
                                    <li>
                                        <div className="score">
                                            <span>
                                                Superb<em>350 Reviews</em>
                                            </span>
                                            <strong>9.0</strong>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        {/* /item */}
                        <div className="item">
                            <div className="box_grid">
                                <figure>
                                    <a href="#0" className="wish_bt" />
                                    <a href="tour-detail.html">
                                        <img
                                            src="panagea/img/tour_5.jpg"
                                            className="img-fluid"
                                            alt=""
                                            width={800}
                                            height={533}
                                        />
                                        <div className="read_more">
                                            <span>Read more</span>
                                        </div>
                                    </a>
                                    <small>Walking</small>
                                </figure>
                                <div className="wrapper">
                                    <h3>
                                        <a href="tour-detail.html">
                                            Tour Eiffel
                                        </a>
                                    </h3>
                                    <p>
                                        Id placerat tacimates definitionem sea,
                                        prima quidam vim no. Duo nobis persecuti
                                        cu.
                                    </p>
                                    <span className="price">
                                        From <strong>$65</strong> /per person
                                    </span>
                                </div>
                                <ul>
                                    <li>
                                        <i className="icon_clock_alt" /> 1h
                                        30min
                                    </li>
                                    <li>
                                        <div className="score">
                                            <span>
                                                Good<em>350 Reviews</em>
                                            </span>
                                            <strong>7.5</strong>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        {/* /item */}
                    </div>
                    {/* /carousel */}
                    <p className="btn_home_align">
                        <a
                            href="tours-grid-isotope.html"
                            className="btn_1 rounded"
                        >
                            View all Tours
                        </a>
                    </p>
                    <hr className="large" />
                </div>
                {/* /container */}
                <div className="container container-custom margin_30_95">
                    <section className="add_bottom_45">
                        <div className="main_title_3">
                            <span>
                                <em />
                            </span>
                            <h2>Popular Hotels and Accommodations</h2>
                            <p>
                                Cum doctus civibus efficiantur in imperdiet
                                deterruisset.
                            </p>
                        </div>
                        <div className="row">
                            <div className="col-xl-3 col-lg-6 col-md-6">
                                <a
                                    href="hotel-detail.html"
                                    className="grid_item"
                                >
                                    <figure>
                                        <div className="score">
                                            <strong>8.9</strong>
                                        </div>
                                        <img
                                            src="panagea/img/hotel_1.jpg"
                                            className="img-fluid"
                                            alt=""
                                        />
                                        <div className="info">
                                            <div className="cat_star">
                                                <i className="icon_star" />
                                                <i className="icon_star" />
                                                <i className="icon_star" />
                                                <i className="icon_star" />
                                            </div>
                                            <h3>Mariott Hotel</h3>
                                        </div>
                                    </figure>
                                </a>
                            </div>
                            {/* /grid_item */}
                            <div className="col-xl-3 col-lg-6 col-md-6">
                                <a
                                    href="hotel-detail.html"
                                    className="grid_item"
                                >
                                    <figure>
                                        <div className="score">
                                            <strong>7.9</strong>
                                        </div>
                                        <img
                                            src="panagea/img/hotel_2.jpg"
                                            className="img-fluid"
                                            alt=""
                                        />
                                        <div className="info">
                                            <div className="cat_star">
                                                <i className="icon_star" />
                                                <i className="icon_star" />
                                                <i className="icon_star" />
                                                <i className="icon_star" />
                                            </div>
                                            <h3>Concorde Hotel </h3>
                                        </div>
                                    </figure>
                                </a>
                            </div>
                            {/* /grid_item */}
                            <div className="col-xl-3 col-lg-6 col-md-6">
                                <a
                                    href="hotel-detail.html"
                                    className="grid_item"
                                >
                                    <figure>
                                        <div className="score">
                                            <strong>7.0</strong>
                                        </div>
                                        <img
                                            src="panagea/img/hotel_3.jpg"
                                            className="img-fluid"
                                            alt=""
                                        />
                                        <div className="info">
                                            <div className="cat_star">
                                                <i className="icon_star" />
                                                <i className="icon_star" />
                                                <i className="icon_star" />
                                                <i className="icon_star" />
                                            </div>
                                            <h3>Louvre Hotel</h3>
                                        </div>
                                    </figure>
                                </a>
                            </div>
                            {/* /grid_item */}
                            <div className="col-xl-3 col-lg-6 col-md-6">
                                <a
                                    href="hotel-detail.html"
                                    className="grid_item"
                                >
                                    <figure>
                                        <div className="score">
                                            <strong>8.9</strong>
                                        </div>
                                        <img
                                            src="panagea/img/hotel_4.jpg"
                                            className="img-fluid"
                                            alt=""
                                        />
                                        <div className="info">
                                            <div className="cat_star">
                                                <i className="icon_star" />
                                                <i className="icon_star" />
                                                <i className="icon_star" />
                                                <i className="icon_star" />
                                            </div>
                                            <h3>Park Yatt Hotel</h3>
                                        </div>
                                    </figure>
                                </a>
                            </div>
                            {/* /grid_item */}
                        </div>
                        {/* /row */}
                        <a href="hotels-grid-isotope.html">
                            <strong>
                                View all (157){" "}
                                <i className="arrow_carrot-right" />
                            </strong>
                        </a>
                    </section>
                    {/* /section */}
                    <section className="add_bottom_45">
                        <div className="main_title_3">
                            <span>
                                <em />
                            </span>
                            <h2>Popular Restaurants</h2>
                            <p>
                                Cum doctus civibus efficiantur in imperdiet
                                deterruisset.
                            </p>
                        </div>
                        <div className="row">
                            <div className="col-xl-3 col-lg-6 col-md-6">
                                <a
                                    href="restaurant-detail.html"
                                    className="grid_item"
                                >
                                    <figure>
                                        <div className="score">
                                            <strong>8.5</strong>
                                        </div>
                                        <img
                                            src="panagea/img/restaurant_1.jpg"
                                            className="img-fluid"
                                            alt=""
                                        />
                                        <div className="info">
                                            <h3>Da Alfredo</h3>
                                        </div>
                                    </figure>
                                </a>
                            </div>
                            {/* /grid_item */}
                            <div className="col-xl-3 col-lg-6 col-md-6">
                                <a
                                    href="restaurant-detail.html"
                                    className="grid_item"
                                >
                                    <figure>
                                        <div className="score">
                                            <strong>7.9</strong>
                                        </div>
                                        <img
                                            src="panagea/img/restaurant_2.jpg"
                                            className="img-fluid"
                                            alt=""
                                        />
                                        <div className="info">
                                            <h3>Slow Food</h3>
                                        </div>
                                    </figure>
                                </a>
                            </div>
                            {/* /grid_item */}
                            <div className="col-xl-3 col-lg-6 col-md-6">
                                <a
                                    href="restaurant-detail.html"
                                    className="grid_item"
                                >
                                    <figure>
                                        <div className="score">
                                            <strong>7.5</strong>
                                        </div>
                                        <img
                                            src="panagea/img/restaurant_3.jpg"
                                            className="img-fluid"
                                            alt=""
                                        />
                                        <div className="info">
                                            <h3>Bella Napoli</h3>
                                        </div>
                                    </figure>
                                </a>
                            </div>
                            {/* /grid_item */}
                            <div className="col-xl-3 col-lg-6 col-md-6">
                                <a
                                    href="restaurant-detail.html"
                                    className="grid_item"
                                >
                                    <figure>
                                        <div className="score">
                                            <strong>9.0</strong>
                                        </div>
                                        <img
                                            src="panagea/img/restaurant_4.jpg"
                                            className="img-fluid"
                                            alt=""
                                        />
                                        <div className="info">
                                            <h3>Marcus</h3>
                                        </div>
                                    </figure>
                                </a>
                            </div>
                            {/* /grid_item */}
                        </div>
                        {/* /row */}
                        <a href="restaurants-grid-isotope.html">
                            <strong>
                                View all (157){" "}
                                <i className="arrow_carrot-right" />
                            </strong>
                        </a>
                    </section>
                    {/* /section */}
                    <div className="banner mb-0">
                        <div
                            className="wrapper d-flex align-items-center opacity-mask"
                            data-opacity-mask="rgba(0, 0, 0, 0.3)"
                        >
                            <div>
                                <small>Adventure</small>
                                <h3>
                                    Your Perfect
                                    <br />
                                    Advenure Experience
                                </h3>
                                <p>Activities and accommodations</p>
                                <a href="adventure.html" className="btn_1">
                                    Read more
                                </a>
                            </div>
                        </div>
                        {/* /wrapper */}
                    </div>
                    {/* /banner */}
                </div>
                {/* /container */}
                <div className="bg_color_1">
                    <div className="container margin_80_55">
                        <div className="main_title_2">
                            <span>
                                <em />
                            </span>
                            <h3>News and Events</h3>
                            <p>
                                Cum doctus civibus efficiantur in imperdiet
                                deterruisset.
                            </p>
                        </div>
                        <div className="row">
                            <div className="col-lg-6">
                                <a className="box_news" href="#0">
                                    <figure>
                                        <img
                                            src="panagea/img/news_home_1.jpg"
                                            alt=""
                                        />
                                        <figcaption>
                                            <strong>28</strong>Dec
                                        </figcaption>
                                    </figure>
                                    <ul>
                                        <li>Mark Twain</li>
                                        <li>20.11.2017</li>
                                    </ul>
                                    <h4>Pri oportere scribentur eu</h4>
                                    <p>
                                        Cu eum alia elit, usu in eius appareat,
                                        deleniti sapientem honestatis eos ex. In
                                        ius esse ullum vidisse....
                                    </p>
                                </a>
                            </div>
                            {/* /box_news */}
                            <div className="col-lg-6">
                                <a className="box_news" href="#0">
                                    <figure>
                                        <img
                                            src="panagea/img/news_home_2.jpg"
                                            alt=""
                                        />
                                        <figcaption>
                                            <strong>28</strong>Dec
                                        </figcaption>
                                    </figure>
                                    <ul>
                                        <li>Jhon Doe</li>
                                        <li>20.11.2017</li>
                                    </ul>
                                    <h4>Duo eius postea suscipit ad</h4>
                                    <p>
                                        Cu eum alia elit, usu in eius appareat,
                                        deleniti sapientem honestatis eos ex. In
                                        ius esse ullum vidisse....
                                    </p>
                                </a>
                            </div>
                            {/* /box_news */}
                            <div className="col-lg-6">
                                <a className="box_news" href="#0">
                                    <figure>
                                        <img
                                            src="panagea/img/news_home_3.jpg"
                                            alt=""
                                        />
                                        <figcaption>
                                            <strong>28</strong>Dec
                                        </figcaption>
                                    </figure>
                                    <ul>
                                        <li>Luca Robinson</li>
                                        <li>20.11.2017</li>
                                    </ul>
                                    <h4>Elitr mandamus cu has</h4>
                                    <p>
                                        Cu eum alia elit, usu in eius appareat,
                                        deleniti sapientem honestatis eos ex. In
                                        ius esse ullum vidisse....
                                    </p>
                                </a>
                            </div>
                            {/* /box_news */}
                            <div className="col-lg-6">
                                <a className="box_news" href="#0">
                                    <figure>
                                        <img
                                            src="panagea/img/news_home_4.jpg"
                                            alt=""
                                        />
                                        <figcaption>
                                            <strong>28</strong>Dec
                                        </figcaption>
                                    </figure>
                                    <ul>
                                        <li>Paula Rodrigez</li>
                                        <li>20.11.2017</li>
                                    </ul>
                                    <h4>Id est adhuc ignota delenit</h4>
                                    <p>
                                        Cu eum alia elit, usu in eius appareat,
                                        deleniti sapientem honestatis eos ex. In
                                        ius esse ullum vidisse....
                                    </p>
                                </a>
                            </div>
                            {/* /box_news */}
                        </div>
                        {/* /row */}
                        <p className="btn_home_align">
                            <a href="blog.html" className="btn_1 rounded">
                                View all news
                            </a>
                        </p>
                    </div>
                    {/* /container */}
                </div>
                {/* /bg_color_1 */}
                <div className="call_section">
                    <div className="container clearfix">
                        <div
                            className="col-lg-5 col-md-6 float-right wow"
                            data-wow-offset={250}
                        >
                            <div className="block-reveal">
                                <div className="block-vertical" />
                                <div className="box_1">
                                    <h3>Enjoy a GREAT travel with us</h3>
                                    <p>
                                        Ius cu tamquam persequeris, eu veniam
                                        apeirian platonem qui, id aliquip
                                        voluptatibus pri. Ei mea primis ornatus
                                        disputationi. Menandri erroribus cu per,
                                        duo solet congue ut.{" "}
                                    </p>
                                    <a href="#0" className="btn_1 rounded">
                                        Read more
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {/*/call_section*/}
                <Footer />

                <Helmet>
                    <script src="panagea/js/video_header.js"></script>
                </Helmet>
            </div>
        );
    }
}

export default IndexContent;
