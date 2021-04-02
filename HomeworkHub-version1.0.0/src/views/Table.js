import React from "react";
import BootstrapTable from "react-bootstrap-table-next";
import cellEditFactory from "react-bootstrap-table2-editor";

const products = [
  { id: 1, due: 10, name: "Math #1", link: 1 },
  { id: 2, due: 9, name: "English Spelling", link: 2 },
  { id: 3, due: 8, name: "Grammar", link: 3 },
  { id: 4, due: 7, name: "Art Drawing", link: 2 },
  { id: 5, due: 6, name: "Grammar #2", link: 1 },
  { id: 6, due: 5, name: "English Spelling #2", link: 4 },
//   { id: 7, name: "mango", price: 1 },
//   { id: 8, name: "potatoe", price: 3 },
//   { id: 9, name: "onion", price: 3 }
];

const columns = [
  {
    dataField: "id",
    text: "HW ID",
    sort: true
  },

  {
    dataField: "due",
    text: "due dates",
    sort: true
  },

  {
    dataField: "name",
    text: "HW Name",
    sort: true
  },

  {
    dataField: "link",
    text: "Link to HW",
    sort: true,
    validator: (newValue, row, column) => {
      if (isNaN(newValue)) {
        return {
          valid: false,
          message: "Price should be numeric"
        };
      }
      if (newValue > 5) {
        return {
          valid: false,
          message: "Price should less than 6"
        };
      }
      return true;
    }
  }
];

const defaultSorted = [
  {
    dataField: "name",
    order: "desc"
  }
];

export default class Table extends React.Component {
  render() {
    return (
      <BootstrapTable
        bootstrap4
        keyField="id"
        data={products}
        columns={columns}
        defaultSorted={defaultSorted}
        cellEdit={cellEditFactory({
          mode: "click",
          blurToSave: true
        })}
      />
    );
  }
}
