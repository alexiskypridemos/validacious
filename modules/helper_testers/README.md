# Helper Testers Overview Module

This module provides a centralized dashboard for accessing all helper tester modules in the Trongate framework.

## Purpose

The Helper Testers Overview serves as a single entry point to run and manage tests for all core helper functions, making it easy to validate the entire helper ecosystem.

## Features

- **Centralized Access**: Links to all 5 helper tester modules
- **Quick Actions**: Direct buttons to run tests for each helper
- **Documentation Links**: Easy access to README files for each tester
- **Clean UI**: Styled with Trongate CSS for consistent appearance

## Tester Modules Included

1. **Form Helper Tester** - Tests form input generation (inputs, checkboxes, textareas, etc.)
2. **Flashdata Helper Tester** - Tests flash message functionality
3. **String Helper Tester** - Tests string manipulation functions
4. **URL Helper Tester** - Tests URL parsing and link generation
5. **Utilities Helper Tester** - Tests utility functions (sorting, file info, etc.)

## Usage

1. Navigate to `/helper_testers` in your browser
2. Click "Run Tests" to execute tests for any helper
3. Click "View README" to see detailed documentation
4. Review test results and ensure all pass

## Styling

The page uses Trongate's default CSS with custom enhancements for:

- Card-based layout for each tester
- Consistent button styling
- Responsive design
- Clean typography

## Dependencies

- Requires all 5 tester modules to be installed
- Uses `public/css/trongate.css` for styling
