import department from "./department"
import designation from "./designation"
import branch from "./branch"

export default [
    {
        path: "company",
        name: "Company",
        redirect: { name: "CompanyDepartment" },
        meta: {
            label: "company.company",
            icon: "fas fa-building",
            permissions: ["branch:read", "department:read", "designation:read"],
        },
        component: {
            template: "<router-view></router-view>",
        },
        children: [...department, ...designation, ...branch],
    },
]
