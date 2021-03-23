import Dashboard from "views/Dashboard.js";
import UserProfile from "views/UserProfile.js";
import addHW from "views/addHW.js";
import addDue from "views/addDue.js";
import addTest from "views/addTest.js";
import viewStudent from "views/viewStudent.js";
import viewClass from "views/viewClass.js";

const dashboardRoutes = [
  
  {
    path: "/dashboard",
    name: "Dashboard",
    icon: "nc-icon nc-circle-09",
    component: Dashboard,
    layout: "/admin",
  },
  {
    path: "/user",
    name: "User Profile",
    icon: "nc-icon nc-circle-09",
    component: UserProfile,
    layout: "/admin",
  },
  {
    path: "/table",
    name: "View Homework",
    icon: "nc-icon nc-circle-09",
    component: addHW,
    layout: "/admin",
  },
  {
    path: "/typography",
    name: "View Due Dates",
    icon: "nc-icon nc-circle-09",
    component: addDue,
    layout: "/admin",
  },
  {
    path: "/icons",
    name: "View Test",
    icon: "nc-icon nc-circle-09",
    component: addTest,
    layout: "/admin",
  },
  {
    path: "/maps",
    name: "View Students",
    icon: "nc-icon nc-circle-09",
    component: viewStudent,
    layout: "/admin",
  },
  {
    path: "/notifications",
    name: "View Classroom",
    icon: "nc-icon nc-circle-09",
    component: viewClass,
    layout: "/admin",
  },
];

export default dashboardRoutes;
