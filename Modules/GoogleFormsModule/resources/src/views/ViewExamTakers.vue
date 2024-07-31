<script setup>
import { onMounted, ref, watch } from "vue";
import NavComponent from "../components/NavComponent.vue";
import { useAuthStore } from "../stores/auth";
import { useRoute, useRouter } from "vue-router";
import debounce from "lodash.debounce";
import { toast } from "vue3-toastify";
// modal imports
import EditStudentGradeModal from "../components/EditStudentGradeModal.vue";
import DeleteStudentGradeConfirmationModel from "../components/DeleteStudentGradeConfirmationModel.vue";

// datatable imports
import Vue3Datatable from "@bhplugin/vue3-datatable";
import "@bhplugin/vue3-datatable/dist/style.css";

const router = useRouter();

const datatable = ref(null);

const selected = ref([]);

const selectAllFlag = ref(false);

const route = useRoute();
const authStore = useAuthStore();
const id = parseInt(route.params.id);

const studentsData = ref([]);

const paginationData = ref({
  total: 0,
  per_page: 10,
  current_page: 1,
  last_page: 0,
  from: 0,
  to: 0,
});

const params = ref({
  sort: "", //column name
  direction: "", // asc , desc
  search: "", // any search term
  page: "1",
  per_page: 10,
});

const loading = ref(false);

// to hold the data which is passed to the two modals
const activeStudentData = ref({});

const cols = ref([
  {
    field: "id",
    title: "#",
    type: "number",
    filter: false,
    sort: false,
  },
  { field: "user_name", title: "Name", filter: ["contains"] },
  { field: "user_email", title: "Email" },
  { field: "degree", title: "Grade", type: "number", filter: ["eq", "gte"] },
  { field: "start_time", title: "Start Time", type: "date" },
  { field: "end_time", title: "End Time", type: "date" },
  { field: "finish_in_time", title: "Finished in Time ?", type: "bool" },
  { field: "questions_count", title: "Number of Questions", type: "number" },
  {
    field: "right_answers_count",
    title: "Number of Correct Answers",
    type: "number",
  },
  {
    field: "wrong_answers_count",
    title: "Number of Wrong Answers",
    type: "number",
  },
  { field: "actions", title: "Actions", filter: false, sort: false },
]);

const fetchExamTakers = async () => {
  //console.log(datatable.value.getSelectedRows(), "on fetch exam takers");
  loading.value = true;

  const formattedParams = new URLSearchParams({
    ...params.value,
  });

  try {
    const res = await fetch(
      `${authStore.baseUrl}/api/form/${id}/student?${formattedParams}`,
      {
        headers: {
          Authorization: `Bearer ${authStore.token}`,
          "Accept": "application/json",
        },
      }
    );
    if (res.status === 401) {
      authStore.handleUnauthorized();
    }
    const { data, pagination } = await res.json();
    studentsData.value = data;
    paginationData.value = pagination;
    loading.value = false;

    //handling selecting items if they are on selected array or select all flag is true

    data.map((item, idx) => {
      if (selected.value.includes(item.id)||selectAllFlag.value) {
        setTimeout(() => {
          datatable.value.selectRow(idx);
        }, 0);
      }
    });
  } catch (error) {
    console.log(error);
    loading.value = false;
  }
};

const handleSelectAll = () => {
  selectAllFlag.value = true;

  // selecting current pages ids
  studentsData.value.map((item, idx) => {
    // adding the item to the selected array
    selected.value = [...new Set([...selected.value,item.id])];

    // checking the items on the ui
    datatable.value.selectRow(idx);
  });
};

const handleExport = async (type) => {
  try {
    // handle trying to export with 0 selected
    if (selected.value.length === 0 && selectAllFlag.value === false) {
      throw new Error(
        "Please select one or more items to export. You haven't selected any items yet."
      );
    }
    const res = await fetch(`${authStore.baseUrl}/api/student/export`, {
      body: JSON.stringify({
        ids: selected.value,
        type,
        selectAll: selectAllFlag.value,
        formId: id,
      }),
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${authStore.token}`,
      },
    });

    if (res.status === 401) {
      authStore.handleUnauthorized();
    }
    // handling download
    const blob = await res.blob();
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = type === "pdf" ? "examTakers.pdf" : "examTakers.xlsx";
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
  } catch (error) {
    toast.error(error.message, {
      autoClose: 2000,
      position: "top-left",
    });
  }
};

const handleViewQuiz = (user) => {
  //console.log(user);
  router.push(`/googleformsmodule/${user.id}/quizResults`);
};

const handleRowSelect = () => {
  const selectedIdsWithDuplications = [
    ...selected.value,
    ...datatable.value.getSelectedRows().map((e) => e.id),
  ];
  selected.value = [...new Set(selectedIdsWithDuplications)];

};

// Debounce the fetchExamTakers function // to optimize and reduce number of calls for the fetch exam takers  function
const debouncedFetchExamTakers = debounce(fetchExamTakers, 300);

const reset = () => {
  datatable.value.reset();
  params.value = {
    sort: "", //column name
    direction: "", // asc , desc
    search: "", // any search term
    page: "1",
    per_page: 10,
  };
  selected.value = [];
  selectAllFlag.value=false
};

// a function to add filters to the params for the request
const updateParamsWithFilters = (data) => {
  //getting the filters with value only
  const filtersWithValue = data.column_filters.filter((filter) => {
    // handling finish in time filter as it could have  a false value
    if (filter.field === "finish_in_time" && filter.value === false) {
      return true;
    }
    return (
      filter.condition === "is_not_null" ||
      filter.condition === "is_null" ||
      filter.value ||
      filter.value === 0
    ); // returning filters with values even if its 0 and filters with only is null  or in not null operations
  });

  // setting the params with their key_value
  filtersWithValue.map((filter) => {
    const { field, condition, value } = filter;

    params.value[field] = `${value}_${condition}`;

    if (field === "finish_in_time") {
      // console.log(field, condition, value);

      params.value[field] = `${value ? 1 : 0}_${value ? true : false}`;
    }
  });
};

// a function to fire for any datatable change
const changeServer = (data) => {
  // console.log(data);
  //console.log(datatable.value.getSelectedRows(), "on change server");
  // updating fetch params on change

  params.value.page = data.current_page;
  params.value.search = data.search;
  params.value.sort = data.sort_column;
  params.value.direction = data.sort_direction;
  params.value.per_page = data.pagesize;

  // managing columns filters
  updateParamsWithFilters(data);

  // re fetech users when any param change
  debouncedFetchExamTakers();
};

watch(paginationData, () => {
  //selected.value = [...selected.value,...datatable.value.getSelectedRows()]
  //console.log(datatable.value.getSelectedRows(), "on watch");
  //console.log("page changed ==>", paginationData.value.current_page);
});

onMounted(() => {
  fetchExamTakers();
});
</script>

<template>
  <NavComponent />
  <div class="container">
    <!-- <button @click="console.log(params)">click to print params</button> -->
    <div class="d-flex justify-content-between my-3">
      <!-- columns filter -->
      <div class="dropdown">
        <button
          class="btn btn-primary dropdown-toggle"
          type="button"
          id="dropdownMenuButton1"
          data-bs-toggle="dropdown"
          aria-expanded="false"
        >
          Column Chooser
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <li v-for="col in cols" :key="col.field" class="dropdown-item" @click.stop>
            <label
              class="d-flex align-items-center justify-content-between px-3 text-end"
            >
              <input
                type="checkbox"
                class="form-checkbox me-3"
                :checked="!col.hide"
                @change="col.hide = !$event.target.checked"
              />
              <span>{{ col.title }}</span>
            </label>
          </li>
        </ul>

        <button
          class="btn btn-primary dropdown-toggle ms-1"
          type="button"
          id="dropdownMenuButton2"
          data-bs-toggle="dropdown"
          aria-expanded="false"
        >
          Export
        </button>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
          <li class="dropdown-item" @click.stop="handleExport('pdf')">pdf</li>
          <li class="dropdown-item" @click.stop="handleExport('excel')">excel</li>
        </ul>
        <button class="btn btn-primary ms-1" @click="handleSelectAll">select all</button>
        <button class="btn btn-danger ms-1" @click="reset">reset</button>
      </div>

      <!-- search bar  -->
      <input
        v-model="params.search"
        type="text"
        class="form-input max-w-xs p-3 border"
        placeholder="Search..."
      />
    </div>

    <vue3-datatable
      class="viewExamTakersTable"
      ref="datatable"
      :rows="studentsData"
      :columns="cols"
      :loading="loading"
      :totalRows="paginationData.total"
      :hasCheckbox="true"
      :page="paginationData.current_page"
      :pageSize="paginationData.per_page"
      :sortable="true"
      :sortColumn="params.sort_column"
      :sortDirection="params.sort_direction"
      :stickyFirstColumn="true"
      :showNumbersCount="5"
      :search="params.search"
      :isServerMode="true"
      :columnFilter="true"
      rowClass="rowClass"
      cellClass="cellClass"
      @change="changeServer"
      @rowSelect="handleRowSelect"
    >
      <template #id="data">
        <strong># {{ data.value.index }}</strong>
      </template>

      <template #actions="data">
        <div class="d-flex">
          <button
            class="btn btn-primary me-1"
            type="button"
            @click.stop="handleViewQuiz(data.value)"
          >
            View
          </button>
          <!-- <button
            class="btn btn-primary me-1"
            type="button"
            data-bs-toggle="modal"
            data-bs-target="#exampleModal"
            @click.stop="activeStudentData = { ...data.value }"
          >
            Edit
          </button> -->

          <button
            class="btn btn-danger me-1"
            type="button"
            data-bs-toggle="modal"
            data-bs-target="#deleteStudentRecord"
            @click.stop="activeStudentData = { ...data.value }"
          >
            Delete
          </button>
        </div>
      </template>
    </vue3-datatable>
  </div>
  <!-- modals  -->
  <EditStudentGradeModal
    :studentData="activeStudentData"
    @refetchExamTakers="fetchExamTakers"
  />

  <DeleteStudentGradeConfirmationModel
    :studentData="activeStudentData"
    @refetchExamTakers="fetchExamTakers"
  />
</template>

<style>
/* styles for the data table */
.bh-datatable.bh-antialiased.bh-relative.bh-text-black.bh-text-sm.bh-font-normal.viewExamTakersTable
  .bh-table-responsive {
  min-height: 70vh !important;
}
/* hide filters that are not needed in string filters */
div[type="string"] .bh-font-normal.bh-rounded.bh-overflow-hidden button:nth-of-type(1),
div[type="string"] .bh-font-normal.bh-rounded.bh-overflow-hidden button:nth-of-type(3),
div[type="string"] .bh-font-normal.bh-rounded.bh-overflow-hidden button:nth-of-type(5),
div[type="string"] .bh-font-normal.bh-rounded.bh-overflow-hidden button:nth-of-type(6),
div[type="string"] .bh-font-normal.bh-rounded.bh-overflow-hidden button:nth-of-type(7) {
  display: none;
}

/* hide filters that are not needed in number & date filters */
div[type="number"] .bh-font-normal.bh-rounded.bh-overflow-hidden button:nth-of-type(1),
div[type="number"] .bh-font-normal.bh-rounded.bh-overflow-hidden button:nth-of-type(3),
div[type="date"] .bh-font-normal.bh-rounded.bh-overflow-hidden button:nth-of-type(1),
div[type="date"] .bh-font-normal.bh-rounded.bh-overflow-hidden button:nth-of-type(3) {
  display: none;
}

/* hide filters that are not needed in the bool */
select.bh-form-control option:not([value]) {
  display: none;
}

.viewExamTakersTable input[type="number"]::-webkit-inner-spin-button,
.viewExamTakersTable input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
.rowClass {
  /* cursor: pointer; */
  text-wrap: nowrap;
}

/* .rowClass:hover {
    background-color: rgba(128, 128, 128, 0.212) !important;
} */
.cellClass {
}

.viewExamTakersTable th div {
  font-weight: bold;
  text-wrap: nowrap;
}
</style>
