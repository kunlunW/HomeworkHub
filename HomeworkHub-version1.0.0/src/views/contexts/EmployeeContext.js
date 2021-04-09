import {createContext, useEffect, useState} from 'react';
import { v4 as uuidv4 } from 'uuid';

export const EmployeeContext = createContext()

const EmployeeContextProvider  = (props) => {

    const [employees, setEmployees] = useState([
        {id:uuidv4(), name: 'Test1', email: 'test@badger.com', address: '123 Badger St, WI, USA', phone: '(123)456789'},
        {id:uuidv4(), name: 'Test2', email: 'test@badger.com', address: '123 Badger St, WI, USA', phone: '(123)456789'},
        {id:uuidv4(), name: 'Test3', email: 'test@badger.com', address: '123 Badger St, WI, USA', phone: '(123)456789'},
        {id:uuidv4(), name: 'Test4', email: 'test@badger.com', address: '123 Badger St, WI, USA', phone: '(123)456789'},
        {id:uuidv4(), name: 'Test5', email: 'test@badger.com', address: '123 Badger St, WI, USA', phone: '(123)456789'}
])

useEffect(()=> {
    setEmployees(JSON.parse(localStorage.getItem('employees')))
},[])

useEffect(() => {
    localStorage.setItem('employees', JSON.stringify(employees));
})



const sortedEmployees = employees.sort((a,b)=>(a.name < b.name ? -1 : 1));



const addEmployee = (name, email, address, phone) => {
    setEmployees([...employees , {id:uuidv4(), name, email, address, phone}])
}

const deleteEmployee = (id) => {
    setEmployees(employees.filter(employee => employee.id !== id))
}

const updateEmployee = (id, updatedEmployee) => {
    setEmployees(employees.map((employee) => employee.id === id ? updatedEmployee : employee))
}

    return (
        <EmployeeContext.Provider value={{sortedEmployees, addEmployee, deleteEmployee, updateEmployee}}>
            {props.children}
        </EmployeeContext.Provider>
    )
}

export default EmployeeContextProvider;