import React from "react";
import ReactDOM from "react-dom";
import { BrowserRouter, Route, Switch, Redirect } from "react-router-dom";
import "bootstrap/dist/css/bootstrap.min.css";
import "./assets/scss/light-bootstrap-dashboard-react.scss?v=2.0.0";
import "@fortawesome/fontawesome-free/css/all.min.css";
import AdminLayout from "layouts/Admin.js";
import WelcomeLayout from "layouts/Welcome.js"

ReactDOM.render(
  <BrowserRouter>
    <Switch>
      <Route path="/welcome" render={(props) => <WelcomeLayout {...props} />} />
      <Route path="/admin" render = {(props) => <AdminLayout {...props} />} />
      <Redirect from="/" to="/welcome/login" />
    </Switch>
  </BrowserRouter>,
  document.getElementById("root")
);
