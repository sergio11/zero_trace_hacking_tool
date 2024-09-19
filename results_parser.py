import json
from rich.console import Console
from rich.table import Table

class ResultsProcessor:
    """
    Processes search results for exporting in different formats (HTML, JSON) 
    and displaying them in the console using a formatted table.

    Attributes:
        results (list of dict): A list of dictionaries containing information 
                                about the search results.
    """

    def __init__(self, results):
        """
        Initializes the processor with a list of results.

        Args:
            results (list of dict): The search results to process.
        """
        self.results = results

    def export_html(self, output_file):
        """
        Exports the search results to an HTML file using a predefined template.

        Args:
            output_file (str): The output file where the HTML content will be saved.
        
        Raises:
            FileNotFoundError: If the HTML template file is not found.
        """
        try:
            # Read the HTML template file
            with open("html_template.html", 'r', encoding='utf-8') as f:
                template = f.read()

            # Create HTML elements for each result
            html_elements = ''
            for index, result in enumerate(self.results, start=1):
                element = (
                    f'<div class="result">'
                    f'<div class="index">Result {index}</div>'
                    f'<h5>{result["title"]}</h5>'
                    f'<p>{result["description"]}</p>'
                    f'<a href="{result["link"]}" target="_blank">{result["link"]}</a>'
                    f'</div>'
                )
                html_elements += element

            # Replace the placeholder in the template with the results and write to file
            report_html = template.replace('{{ results }}', html_elements)
            with open(output_file, 'w', encoding='utf-8') as f:
                f.write(report_html)

            print(f"Results exported to HTML. File created: {output_file}")
        
        except FileNotFoundError:
            print("Error: HTML template file 'html_template.html' not found.")
    
    def export_json(self, output_file):
        """
        Exports the search results to a JSON file.

        Args:
            output_file (str): The output file where the JSON content will be saved.
        """
        with open(output_file, 'w', encoding='utf-8') as f:
            json.dump(self.results, f, ensure_ascii=False, indent=4)
        print(f"Results exported to JSON. File created: {output_file}")

    def display_console(self):
        """
        Displays the search results in the console using a formatted table.
        """
        console = Console()
        table = Table(show_header=True, header_style="bold magenta")
        
        # Define table columns
        table.add_column("#", style="dim", justify="center")
        table.add_column("Title", width=50)
        table.add_column("Description")
        table.add_column("Link")

        # Add results to the table
        for index, result in enumerate(self.results, start=1):
            table.add_row(
                str(index), 
                result['title'], 
                result['description'], 
                result['link']
            )
            table.add_row("", "", "", "")  # Add an empty row for visual spacing
        
        # Render the table in the console
        console.print(table)