import { Form, Button } from "react-bootstrap"
import {useState} from 'react';

const EditForm = (props) =>{

    const [newEmployee, setNewEmployee] = useState({
        name:props.theEmployee.name, desc: props.theEmployee.description, date: props.theEmployee.duedate
    });

    const onInputChange = (e) => {
        setNewEmployee({...newEmployee,[e.target.name]: e.target.value})
    }

    const {name, desc, date} = newEmployee;

    const handleSubmit = (e) => {
        e.preventDefault();
        props.updateAnnouncement(props.theEmployee.announcementid, name, desc, date);
    }

     return (

        <Form onSubmit={handleSubmit}>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Name *"
                    name="name"
                    value={name}
                    onChange={(e)=> onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Form.Group>
                <Form.Control
                    type="text"
                    placeholder="Description *"
                    name="desc"
                    value={desc}
                    onChange={(e)=> onInputChange(e)}
                    // required
                />
            </Form.Group>
            <Button variant="success" type="submit" block>
                Edit Announcement
            </Button>
        </Form>

     )
}

export default EditForm;
