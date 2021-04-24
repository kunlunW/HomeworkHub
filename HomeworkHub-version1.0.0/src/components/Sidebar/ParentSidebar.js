
import React, { Component } from "react";
import { useLocation, NavLink } from "react-router-dom";

import { Nav } from "react-bootstrap";

function ParentSidebar({ routes }) {
  const location = useLocation();
  const activeRoute = (routeName) => {
    return location.pathname.indexOf(routeName) > -1 ? "active" : "";
  };
  return (
    <div className="sidebar" data-color={"blue"}>
      <div/>
      <div className="sidebar-wrapper">
        <div className="logo d-flex align-items-center justify-content-start">
          
          <a className="simple-text" >
            ParentHub
          </a>
        </div>
        
        <Nav>
          {routes.map((prop, key) => {
            if (!prop.redirect && prop.layout === "/parent" && prop.name != "Classroom")
              return (
                <li className={ activeRoute(prop.layout + prop.path) } >
                  <NavLink
                    to={prop.layout + prop.path}
                    className="nav-link"
                    activeClassName="active"
                  >
                    <i className={prop.icon} />
                    <p>{prop.name}</p>
                  </NavLink>
                </li>
              );
            return null;
          })}
        </Nav>
      </div>
    </div>
  );
}

export default ParentSidebar;
