import { User } from "@/types"
import { Link, router } from "@inertiajs/react"
import { MdAccountCircle, MdClose, MdMenu } from "react-icons/md"

type Props = {
  user?: User
}

const Navbar = (props: Props) => {

  const handleLogout = () => {
    try {
      router.post(route('logout')); // Make sure to use the correct route name
    } catch (error) {
      console.error('Logout failed:', error);
    }

  }

  return (
    <nav>
      <div className="flex items-center w-full shadow-md px-2 py-2 h-11 justify-between">
        <label htmlFor="my-drawer" className="btn btn-ghost btn-sm btn-square p-0 drawer-button sm:hidden">
          <MdMenu size={24} />
        </label>
        <Link href='/' className="uppercase font-black ">
          <h1>{import.meta.env.VITE_APP_NAME}</h1>
        </Link>

        <details className="dropdown hidden sm:block dropdown-end">
          <summary className="btn btn-sm btn-ghost">
            {props.user?.name || 'Account'} <MdAccountCircle size={24} />
          </summary>
          <ul className="p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-52">
            {props.user ? (
              <>
                <li>
                  <a href="/admin">Admin Page</a>
                </li>
                <li>
                  <button onClick={handleLogout}>Logout</button>
                </li>
              </>
            ) : (
              <>
                <li>
                  <a href={route('login')}>Login</a>
                </li>
                <li>
                  <a href={route('register')}>Register</a>
                </li>
              </>
            )}
          </ul>
        </details>
      </div>
      <div className="drawer sm:hidden">
        <input id="my-drawer" type="checkbox" className="drawer-toggle" />
        <div className="drawer-side">
          <label htmlFor="my-drawer" aria-label="close sidebar" className="drawer-overlay"></label>
          <ul className="menu p-4 w-full max-w-xs min-h-full bg-base-200 text-base-content">
            {/* Sidebar content here */}
            <li>
              <label htmlFor="my-drawer" className="ml-auto btn btn-ghost btn-sm btn-square drawer-button">
                <MdClose size={24} />
              </label>
            </li>
            <li>
              <details className="">
                <summary className="">
                  {props.user?.name || 'Account'} <MdAccountCircle size={24} />
                </summary>
                <ul className="">
                  {props.user ? (
                    <>
                      <li>
                        <a href="/admin">Admin Page</a>
                      </li>
                      <li>
                        <button onClick={handleLogout}>Logout</button>
                      </li>
                    </>
                  ) : (
                    <>
                      <li>
                        <a href={route('login')}>Login</a>
                      </li>
                      <li>
                        <a href={route('register')}>Register</a>
                      </li>
                    </>
                  )}
                </ul>
              </details>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  )
}

export default Navbar
