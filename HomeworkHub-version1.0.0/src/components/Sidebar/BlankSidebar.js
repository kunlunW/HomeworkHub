import React, { Component } from "react";
import { useLocation, NavLink } from "react-router-dom";


function BlankSidebar({ routes }) {
//   const location = useLocation();
//   const activeRoute = (routeName) => {
//     return location.pathname.indexOf(routeName) > -1 ? "active" : "";
//   };
  return (
    <div className="sidebar" data-color={"blue"}>
      <div/>
      <div className="sidebar-wrapper">
        <div className="logo d-flex align-items-center justify-content-start">
            Homework Hub
        </div>
      </div>
    </div>
  );
}

export default BlankSidebar;