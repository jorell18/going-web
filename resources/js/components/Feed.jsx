import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { Redirect } from 'react-router-dom';

class Feed extends Component {

  constructor(props) {
    super(props);
  }

  componentDidMount() {
    //show navbar
    this.props.toggleElementById('navigation', 1);

    console.log('Feed props', this.props);

    var exitButton = document.getElementsByClassName("mfp-close")[0];
    console.log('exit button ', exitButton);
    if (exitButton) {
      this.simulateMouseClick(exitButton);
    }

  }

  simulateMouseClick(element) {
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

  importMapToursJS() {
    const mainApp = document.getElementsByTagName('body')[0];

    const script = document.createElement("script");
    script.async = true;
    script.src = "panagea/js/map_tours.js";
    mainApp.appendChild(script);
  }

  importGoogleMaps() {
    const mainApp = document.getElementsByTagName('body')[0];

    const script = document.createElement("script");
    script.async = true;
    script.src = "http://maps.googleapis.com/maps/api/js";
    mainApp.appendChild(script);
  }

  importMapToursJS() {
    const mainApp = document.getElementsByTagName('body')[0];

    const script = document.createElement("script");
    script.async = true;
    script.src = "panagea/js/markerclusterer.js";
    mainApp.appendChild(script);
  }

  importMapToursJS() {
    const mainApp = document.getElementsByTagName('body')[0];

    const script = document.createElement("script");
    script.async = true;
    script.src = "panagea/js/infobox.js";
    mainApp.appendChild(script);
  }


  render() {
    if (!this.props.appData.signedIn) {
      return <Redirect to="/"> </Redirect>
    }

    if (this.props.appData.user.role === "admin") {
      return <Redirect to="/admin" appData={this.props.appData}> </Redirect>
    }
    return (
      <div>
        <section className="hero_in tours">
          <div className="wrapper">
            <div className="container">
              <h1 className="fadeInUp"><span />Paris tours grid</h1>
            </div>
          </div>
        </section>
        {/*/hero_in*/}
        <div className="filters_listing sticky_horizontal">
          <div className="container">
            <ul className="clearfix">
              <li>
                <div className="switch-field">
                  <input type="radio" id="all" name="listing_filter" defaultValue="all" defaultChecked />
                  <label htmlFor="all">All</label>
                  <input type="radio" id="popular" name="listing_filter" defaultValue="popular" />
                  <label htmlFor="popular">Popular</label>
                  <input type="radio" id="latest" name="listing_filter" defaultValue="latest" />
                  <label htmlFor="latest">Latest</label>
                </div>
              </li>
              <li>
                <div className="layout_view">
                  <a href="#0" className="active"><i className="icon-th" /></a>
                  <a href="tours-list-isotope.html"><i className="icon-th-list" /></a>
                </div>
              </li>
              <li>
                <a className="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="View on map">View on map</a>
              </li>
            </ul>
          </div>
          {/* /container */}
        </div>
        {/* /filters */}
        <div className="collapse" id="collapseMap">
          <div id="map" className="map" />
        </div>
        {/* End Map */}
        <div className="container margin_60_35">
          <div className="wrapper-grid">
            <div className="row">
              <div className="col-xl-4 col-lg-6 col-md-6">
                <div className="box_grid">
                  <figure>
                    <a href="#0" className="wish_bt" />
                    <a href="tour-detail.html"><img src="panagea/img/tour_1.jpg" className="img-fluid" width={800} height={533} /><div className="read_more"><span>Read more</span></div></a>
                    <small>Historic</small>
                  </figure>
                  <div className="wrapper">
                    <h3><a href="tour-detail.html">Arc Triomphe</a></h3>
                    <p>Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cu.</p>
                    <span className="price">From <strong>$54</strong> /per person</span>
                  </div>
                  <ul>
                    <li><i className="icon_clock_alt" /> 1h 30min</li>
                    <li><div className="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div></li>
                  </ul>
                </div>
              </div>
              {/* /box_grid */}
              <div className="col-xl-4 col-lg-6 col-md-6">
                <div className="box_grid">
                  <figure>
                    <a href="#0" className="wish_bt" />
                    <a href="tour-detail.html"><img src="panagea/img/tour_2.jpg" className="img-fluid" width={800} height={533} /><div className="read_more"><span>Read more</span></div></a>
                    <small>Churches</small>
                  </figure>
                  <div className="wrapper">
                    <h3><a href="tour-detail.html">Notredam</a></h3>
                    <p>Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cu.</p>
                    <span className="price">From <strong>$124</strong> /per person</span>
                  </div>
                  <ul>
                    <li><i className="icon_clock_alt" /> 1h 30min</li>
                    <li><div className="score"><span>Good<em>350 Reviews</em></span><strong>7.0</strong></div></li>
                  </ul>
                </div>
              </div>
              {/* /box_grid */}
              <div className="col-xl-4 col-lg-6 col-md-6">
                <div className="box_grid">
                  <figure>
                    <a href="#0" className="wish_bt" />
                    <a href="tour-detail.html"><img src="panagea/img/tour_3.jpg" className="img-fluid" width={800} height={533} /><div className="read_more"><span>Read more</span></div></a>
                    <small>Historic</small>
                  </figure>
                  <div className="wrapper">
                    <h3><a href="tour-detail.html">Versailles</a></h3>
                    <p>Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cu.</p>
                    <span className="price">From <strong>$25</strong> /per person</span>
                  </div>
                  <ul>
                    <li><i className="icon_clock_alt" /> 1h 30min</li>
                    <li><div className="score"><span>Good<em>350 Reviews</em></span><strong>7.0</strong></div></li>
                  </ul>
                </div>
              </div>
              {/* /box_grid */}
              <div className="col-xl-4 col-lg-6 col-md-6">
                <div className="box_grid">
                  <figure>
                    <a href="#0" className="wish_bt" />
                    <a href="tour-detail.html"><img src="panagea/img/tour_4.jpg" className="img-fluid" width={800} height={533} /><div className="read_more"><span>Read more</span></div></a>
                    <small>Museum</small>
                  </figure>
                  <div className="wrapper">
                    <h3><a href="tour-detail.html">Pompidue Museum</a></h3>
                    <p>Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cu.</p>
                    <span className="price">From <strong>$45</strong> /per person</span>
                  </div>
                  <ul>
                    <li><i className="icon_clock_alt" /> 2h 30min</li>
                    <li><div className="score"><span>Superb<em>350 Reviews</em></span><strong>9.0</strong></div></li>
                  </ul>
                </div>
              </div>
              {/* /box_grid */}
              <div className="col-xl-4 col-lg-6 col-md-6">
                <div className="box_grid">
                  <figure>
                    <a href="#0" className="wish_bt" />
                    <a href="tour-detail.html"><img src="panagea/img/tour_5.jpg" className="img-fluid" width={800} height={533} /><div className="read_more"><span>Read more</span></div></a>
                    <small>Walking</small>
                  </figure>
                  <div className="wrapper">
                    <h3><a href="tour-detail.html">Tour Eiffel</a></h3>
                    <p>Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cu.</p>
                    <span className="price">From <strong>$65</strong> /per person</span>
                  </div>
                  <ul>
                    <li><i className="icon_clock_alt" /> 1h 30min</li>
                    <li><div className="score"><span>Good<em>350 Reviews</em></span><strong>7.5</strong></div></li>
                  </ul>
                </div>
              </div>
              {/* /box_grid */}
              <div className="col-xl-4 col-lg-6 col-md-6">
                <div className="box_grid">
                  <figure>
                    <a href="#0" className="wish_bt" />
                    <a href="tour-detail.html"><img src="panagea/img/tour_6.jpg" className="img-fluid" width={800} height={533} /><div className="read_more"><span>Read more</span></div></a>
                    <small>Museum</small>
                  </figure>
                  <div className="wrapper">
                    <h3><a href="tour-detail.html">Louvre Museum</a></h3>
                    <p>Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cu.</p>
                    <span className="price">From <strong>$95</strong> /per person</span>
                  </div>
                  <ul>
                    <li><i className="icon_clock_alt" /> 1h 30min</li>
                    <li><div className="score"><span>Good<em>350 Reviews</em></span><strong>7.8</strong></div></li>
                  </ul>
                </div>
              </div>
              {/* /box_grid */}
            </div>
            {/* /row */}
          </div>
          {/* /wrapper-grid */}
          <p className="text-center"><a href="#0" className="btn_1 rounded add_top_30">Load more</a></p>
        </div>
        {/* /container */}
        <div className="bg_color_1">
          <div className="container margin_60_35">
            <div className="row">
              <div className="col-md-4">
                <a href="#0" className="boxed_list">
                  <i className="pe-7s-help2" />
                  <h4>Need Help? Contact us</h4>
                  <p>Cum appareat maiestatis interpretaris et, et sit.</p>
                </a>
              </div>
              <div className="col-md-4">
                <a href="#0" className="boxed_list">
                  <i className="pe-7s-wallet" />
                  <h4>Payments</h4>
                  <p>Qui ea nemore eruditi, magna prima possit eu mei.</p>
                </a>
              </div>
              <div className="col-md-4">
                <a href="#0" className="boxed_list">
                  <i className="pe-7s-note2" />
                  <h4>Cancel Policy</h4>
                  <p>Hinc vituperata sed ut, pro laudem nonumes ex.</p>
                </a>
              </div>
            </div>
            {/* /row */}
          </div>
          {/* /container */}
        </div>
        {/* /bg_color_1 */}
      </div>

    );
  }
}

export default Feed;