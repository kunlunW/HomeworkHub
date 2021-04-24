import React, { Component } from "react";
import { Route, Switch } from "react-router-dom";
import ParentSidebar from "components/Sidebar/ParentSidebar.js";
import ParentNavbar from "components/Navbars/ParentNavbar.js";
import routes from "../routes.js";

function Parent() {
  const [color, setColor] = React.useState("white");
  const getRoutes = (routes) => {
    return routes.map((prop, key) => {
      if (prop.layout === "/parent") {
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
        <ParentSidebar color={color}  routes={routes} />
        <div className="main-panel">
          <ParentNavbar />
          <div className="content">
            <Switch>{getRoutes(routes)}</Switch>
          </div>
        </div>
      </div>
    </>
  );
}

export default Parent;