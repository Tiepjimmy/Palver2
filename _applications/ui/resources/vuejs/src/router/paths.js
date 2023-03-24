import root from "./_root";
import error_404 from "./_error_404";
import dashboard from "./_dashboard"
import account from "./_account"
import om from "./_om"
import inventory from "./_inventory"

const routes = [].concat(
	dashboard,
	account,
	om,
	inventory,
	error_404
)

root[0].children = routes
export default root
