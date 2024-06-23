<?php

namespace Warkrai\ToDoItem;

enum Commands: string
{
    case LOGIN = 'login';
    case REGISTER = 'register';
    case GET_LIST = 'get_list';
    case CREATE_ITEM = 'create_item';
    case UPDATE_ITEM = 'update_item';
    case DELETE_ITEM = 'delete_item';
    case EXIT = 'exit';
    case HELP = 'help';
}