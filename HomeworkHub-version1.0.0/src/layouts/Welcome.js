import React, { Component } from "react";
import { Route, Switch } from "react-router-dom";
import AdminNavbar from "components/Navbars/AdminNavbar";
import BlankSidebar from "components/Sidebar/BlankSidebar"
import routes from "routes.js";

function Welcome() {
  const [color, setColor] = React.useState("white");
  const getRoutes = (routes) => {
    return routes.map((prop, key) => {
      if (prop.layout === "/welcome") {
        return (
          <Route
            path={prop.layout + prop.path}
            render={(props) => <prop.component {...props} />}
            key={key}
          />
        );
      } else {
        return null;
      }
    });
  };

  React.useEffect(() => {
  }, );
  return (
    <>
      <div className="wrapper">
      <BlankSidebar color={color}  />
        <div className="main-panel">
          <div className="content">
            <Switch>{getRoutes(routes)}</Switch>
          </div>
        </div>
      </div>
    </>
  );
}

export default Welcome;