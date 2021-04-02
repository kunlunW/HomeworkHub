import React, { Component } from "react";
import BootstrapTable from "react-bootstrap-table-next";
import cellEditFactory from "react-bootstrap-table2-editor";
import ToolkitProvider, { CSVExport } from "react-bootstrap-table2-toolkit";
// import "./App.css";

const { ExportCSVButton } = CSVExport;
const pricesData = [
  { id: "1", HW: "English", price: ".." },
  { id: "2", HW: "Math", price: ".." },
  { id: "3", HW: "Spelling", price: ".." }
];

class Table2 extends Component {
  constructor(props) {
    super(props);
    this.state = {
      data: [...pricesData]
    };
    this.prices = this.prices.bind(this);
  }

  prices = action => {
    if (!action) {
      return this.state.data;
    } else {
      switch (action.actionType) {
        case "addRow":
          let newRow = {};
          newRow.id = this.state.data.length + 1;
          newRow.HW = " ";
          newRow.price = " ";
          this.setState({ data: [...this.state.data, newRow] });

          return this.state.data;
        case "deleteRow":
          //this delets different rows only
          let new_state = this.state.data.filter(
            row => row.id !== action.row || row.HW !== action.HW
          );

          this.setState({ data: [...new_state] });
          return this.state.data;
        default:
          return this.state.data;
      }
    }
  };
  render() {
    return (
      <div className="App">
        <RenderExpenseTable data={this.state.data} prices={this.prices} />
      </div>
    );
  }
}

class RenderExpenseTable extends Component {
  constructor(props) {
    super(props);
    this.state = { data: [...this.props.data] };
  }
  componentWillMount() {
    if (!this.state.data.length) {
      this.setState({ data: [...this.props.prices({ action: "data" })] });
    }
  }

  render() {
    let tableData = this.state.data;
    if (JSON.stringify(this.props.data) === JSON.stringify(tableData)) {
      console.log("in rendered table components the new data is: updated ");
    } else {
      console.log("in rendered table components the new data is: not updated ");
      tableData = this.props.data;
    }
    const columns = [
      {
        dataField: "id",
        text: "Id",
        sort: true
      },
      {
        dataField: "HW",
        text: "HW Name",
        sort: true
      },
      {
        dataField: "price",
        text: "Due dates",
        sort: true
      },
      {
        dataField: "databasePkey",
        text: "Action",
        editable: false,
        formatter: (cell, row) => {
          if (row)
            return (
              <button
                className="btn btn-danger btn-xs rounded"
                onClick={() => {
                  this.setState(this.state.data, () => {
                    this.props.prices({
                      actionType: "deleteRow",
                      row: row.id,
                      HW: row.HW
                    });
                  });
                }}
              >
                Delete HW
              </button>
            );
          return null;
        }
      }
    ];

    const defaultSorted = [
        {
          dataField: "HW",
          order: "desc"
        }
      ];



    return (
      <div xs={12} className="col form">
        <ToolkitProvider
          keyField="id"
          data={tableData}
          columns={columns}
          exportCSV
        >
          {props => (
            <div>
              <div className="d-flex justify-content-around p-2">
                <ExportCSVButton
                  className="text-light btn bg-success border-secondary rounded"
                  {...props.csvProps}
                >
                  <span>Export CSV</span>
                </ExportCSVButton>

                <button
                  className="btn bg-success text-light rounded"
                  onClick={() =>
                    this.setState(tableData, () => {
                      this.props.prices({ actionType: "addRow" });
                    })
                  }
                >
                  Add HW
                </button>
              </div>
              <BootstrapTable
                {...props.baseProps}
                keyField="id"
                data={tableData}
                defaultSorted={defaultSorted}
                columns={columns}
                cellEdit={cellEditFactory({
                  mode: "click",
                  blurToSave: true,
                  onStartEdit: (row, column, rowIndex, columnIndex) => {},
                  beforeSaveCell: (oldValue, newValue, row, column) => {
                    if (column.dataField === "price") {
                      if (isNaN(Number(newValue))) {
                        alert(
                          "You entered " +
                            newValue +
                            " Please Enter dates Only!!"
                        );
                      }
                    }
                  },
                  afterSaveCell: (oldValue, newValue, row, column) => {}
                })}
              />
            </div>
          )}
        </ToolkitProvider>
      </div>
    );
  }
}

export default Table2;
