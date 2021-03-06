import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { Redirect } from 'react-router-dom';

class NotFound extends Component {
  render() {
    return (
      <div>
        <section id="hero">
  <div className="intro_title error">
    <h1 className="animated fadeInDown">404</h1>
    <p className="animated fadeInDown">Oops!! Page not found</p>
    <Redirect to="/"><button className="animated fadeInUp button_intro">Back to home</button> </Redirect>
  </div>
</section>
</div>
    );
  }
}

export default NotFound;