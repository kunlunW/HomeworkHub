import {createContext, useEffect, useState} from 'react';
import { v4 as uuidv4 } from 'uuid';

export const EmployeeContext = createContext()

const EmployeeContextProvider  = (props) => {

    const [hwdue, setEmployees] = useState([
        {id:uuidv4(), name: 'Test1', time: 'test@badger.com', limit: '123 Badger St, WI, USA', points: '(123)456789'},
  
])

useEffect(()=> {
    setEmployees(JSON.parse(localStorage.getItem('hwdue')))
},[])

useEffect(() => {
    localStorage.setItem('hwdue', JSON.stringify(hwdue));
})



const sortedEmployees = hwdue.sort((a,b)=>(a.name < b.name ? -1 : 1));



const addEmployee = (name, time, limit, points) => {
    setEmployees([...hwdue , {id:uuidv4(), name, time, limit, points}])
}

const deleteEmployee = (id) => {
    setEmployees(hwdue.filter(employee => employee.id !== id))
}

const updateEmployee = (id, updatedEmployee) => {
    setEmployees(hwdue.map((employee) => employee.id === id ? updatedEmployee : employee))
}

    return (
        <EmployeeContext.Provider value={{sortedEmployees, addEmployee, deleteEmployee, updateEmployee}}>
            {props.children}
        </EmployeeContext.Provider>
    )
}

export default EmployeeContextProvider;